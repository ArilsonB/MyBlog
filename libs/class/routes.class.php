<?php
    namespace MyB;
    use MyB\Error;
    use MyB\Template;
    require_once(dirname(__FILE__) . '/../class/error.class.php');
    require_once(dirname(__FILE__) . '/../class/template.class.php');
    class Routes {
        private static $router = ('routes.json');
        private static $routes = array();
        private static $url;
        private static $rules;
        private static $route_worker;
        private static $action;
        private static $template;
        public static $dir;

        public function __construct(){}
        public function __destruct(){}

        public static function init(){
            $url = $_SERVER["SCRIPT_NAME"];
            $url = rtrim( dirname($url), '/' );
            $url = '' . trim( str_replace( $url, '', $_SERVER['REQUEST_URI'] ), '' );
            $url = urldecode( $url );
            $url = strtok($url,'?');
            self::$url = $url;
            self::$dir = dirname( __FILE__ ) . '/../../src/';
            self::$template = new Template();
        }
        public static function add($exp,$data=null,$method = ['get','post'],$action=null){
            return self::made($exp,$data,$method,$action);
        }
        public static function get($exp,$data=null,$action=null){
            return self::made($exp,$data,'get',$action);
        }
        public static function post($exp,$data=null,$action=null){
            return self::made($exp,$data,'post',$action);
        }
        public static function group($exp,$groups=array(),$method='get',$action=null){
            foreach($groups as $group){
                $group_url = isset($group[0]) ? $group[0] : '(|\/)';
                $group_url = $exp.$group_url;
                $data = isset($group[1]) ? $group[1] : null;
                $method = isset($group[2]) ? $group[2] : $method;
                self::made($group_url,$data,$method,$action);
            }
            return true;
        }

        public static function switch($exp = '/'){
            return false;
        }

        public static function rules($file='friendly_url.json'){
            $rules = @file_get_contents(dirname(__FILE__) . "/../json/$file");
            $rules = @json_decode($rules, true);
            $rules = $rules['friendly_urls'];
            return $rules;
        }

        private static function handle(){
            foreach ( self::rules() as $action => $rule ) {
                $action = $action;
                self::add($rule,function($req,$res){
                    $template = $res['template'];
                    $template->output($req['action']);
                }, ['get','post'], $action);
            }
        }

        private static function made($exp,$data=null,$method='get',$action=null){
            $pattern = "/:[a-zA-Z0-9]+/i";
            if(preg_match_all($pattern, $exp, $matches, PREG_UNMATCHED_AS_NULL)){
                foreach($matches[0] as $match){
                    $expo = str_replace(':','',$match);
                    $exp = str_replace($match,"(?'$expo'[^/]+)",$exp);
                }
            }
            $array = array(
                'exp' => $exp,
                'action' => $action,
                'data' => $data,
                'method' => $method
            );
            return self::set($array);
        }

        private static function set($arr = array()){
            return array_push(self::$routes,$arr);
        }

        public static function static($serve_path = '/',$serve_folder = '/public'){
            $static = [
                'exp' => $serve_path . '/(.*?)',
                'action' => null,
                'data' => function($req) use($serve_folder) { 
                    $file = $req['params'][0];
                    $folder = $serve_folder;
                    if($ext = pathinfo($file, PATHINFO_EXTENSION)){
                        if(in_array($ext,['html','php','json','xml','xhtml'])){
                            return Error::Get('404');
                        }
                        $file = $folder . '/' . $file;
                        if(is_file($file)){
                            $type = mime_content_type($file);
                            if($type = 'text/plain'){
                                switch($ext){
                                    case 'css':
                                        $type = 'text/css';
                                    break;
                                    case 'js':
                                        $type = 'text/javascript';
                                    break;
                                    default:
                                        $type = 'text/plain';
                                    break;
                                }
                            }
                            if($file = @file_get_contents($file)){
                                header("Content-Type: $type");
                                return exit($file);
                            }else{
                                Error::get('404');
                            }
                        }else{
                            Error::get('404');
                        }
                    }else{
                        Error::get('404');
                    }
                },
                'method' => 'get'
            ];
            return self::set($static);
        }

        public static function run(){
            self::handle();
            $method = $_SERVER['REQUEST_METHOD'];
            $path_found = false;
            $route_found = false;
            foreach(self::$routes as $route){
                if(preg_match( '#^'.$route['exp'].'$#', self::$url, $params)){
                    $path_found = true;

                    foreach ((array)$route['method'] as $allowedMethod) {
                        if (strtolower($method) == strtolower($allowedMethod)) {
                            array_shift($params);
                            $route_found = true;
                            $action = $route['action'];
                            $requisition = array(
                                'action' => $action,
                                'params' => $params,
                                'method' => $method
                            );
                            $response = array(
                                'send' => function($text){
                                    echo $text;
                                },
                                'sendFile' => function($file){
                                    ob_start();
                                    @require $file;
                                    $file = ob_get_contents();
                                    ob_end_clean();
                                    echo $file;
                                },
                                'render' => function($file){
                                    self::$template->output($file);
                                },
                                'template' => self::$template
                            );
                            switch($route['action']){
                                default:
                                    if(is_callable($route['data'])){
                                        return call_user_func($route['data'],$requisition,$response);
                                    }
                                break;
                                case 'dash':
                                    return require(self::$dir . "/manage/$params[0].php");
                                break;
                            }
                            break;
                        }
                    }
                }
                if($route_found){
                    break;
                }
            }

            if(!$route_found){
                if($path_found){
                    self::error('405');
                }else{
                    self::error('404');
                }
            }

        }

        private static function error($code){
            return Error::Get($code);
        }
    }
