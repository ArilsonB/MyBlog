<?php
    require_once(dirname(__FILE__) . '/../template/template.export.php');

    class MybError {
        protected $template;

        private static function expoTemplate(){
            return ExpoTemplate::getTemplate();
        }

        public function __construct(){
            $this->template = self::expoTemplate();
            $errLib = @file_get_contents(dirname(__FILE__) . '/../error/error.json');
            $errLib = @utf8_encode($errLib);
            $errLib = @json_decode($errLib, true);
            $this->error = $errLib;

        }

        public function get($code){
            if($code === '404'){
                $uri = $_SERVER["SCRIPT_NAME"];
                $uri = rtrim( dirname($uri), '/' );
                $uri = '' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '' );
                $uri = urldecode( $uri );
                $uri = strtok($uri,'?');
            }else{
                $uri = "./";
            }
            $errCode = $this->error[$code]['code'];
            $errMessage = sprintf($this->error[$code]['message'],$uri);
            header("HTTP/1.0 $code Not Found File: ". $uri);
            header('Content-Type: text/html');
            $eCode = http_response_code();
            $this->template->__set("errCode",$errCode);
            $this->template->__set("errMessage",$errMessage);
            $this->template->__set("errFile",$errCode);
            $this->template->__set("errLine",$errCode);

            echo $this->template->output('error');
        }
    }

?>