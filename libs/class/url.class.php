<?php
    require_once(dirname(__FILE__) . '/../sql/ExportDB.class.php');
    use MyB\Error;
    require_once(dirname(__FILE__) . '/error.class.php');
    class URL {
        protected $uri;

        private static function connectDB(){
            return ExportDB::getDB();
        }

        public function __construct(){
            // Get Url
            $uri = $_SERVER["SCRIPT_NAME"];
            $uri = rtrim( dirname($uri), '/' );
            $uri = '' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '' );
            $uri = urldecode( $uri );
            $uri = strtok($uri,'?');
            $this->url = $uri;
            $this->dir = dirname( __FILE__ ) . '/../pages/';
        }
        public function get_rules(){
            $rules = @file_get_contents(dirname(__FILE__) . '/../json/friendly_url.json');
            $rules = @json_decode($rules, true);
            $rules = $rules['friendly_urls'];
            $this->rules = $rules;
        }
        public function url_handling(){
            $sql = $this->connectDB();
            require_once(dirname(__FILE__) . "/../template/template.class.php");
            $template = new Template();
            require_once(dirname(__FILE__) . "/../template/template.config.php");
            $i = 0;
            foreach ( $this->rules as $action => $rule ) {
                if ( preg_match( '~^'.$rule.'$~i', $this->url, $params) ) {
                    switch($action){
                        default:
                            return require($this->dir . $action . ".php");
                        break;
                        case 'dash':
                            return require($this->dir . $params[1] . ".php");
                        break;
                        case 'static':
                            $ext = $extensao = pathinfo($params[1], PATHINFO_EXTENSION);
                            switch($ext){
                                default:
                                    return Error::Get('404');
                                break;
                                case 'css':
                                    header('Content-Type: text/css');
                                break;
                                case 'jpg':
                                    header('Content-type: image/jpeg');
                                break;
                                case 'png':
                                    header('Content-Type: image/png');
                                break;
                                case 'js':
                                    header('Content-Type: text/javascript');
                                break;
                            }
                            $file = file_get_contents(dirname( __FILE__ ) . '/../../global/templates/' . $template->theme . '/' . $params[1]);
                            return exit($file);
                        break;
                    }
                }
                $i++;
            }
            $i = intval($i);
            $ruleCount = intval(count($this->rules));
            if($i = $ruleCount){
                return Error::Get('404');
            }
            
        }
        public function __destruct(){
            $this->get_rules();
            return $this->url_handling();
        }
    }
?>