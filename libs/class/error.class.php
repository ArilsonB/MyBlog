<?php
    namespace Myb;
    use MyB\ExpoTemplate;
    require_once(dirname(__FILE__) . '/../template/template.export.php');
    class Error {
        private static $template;

        private static function expoTemplate(){
            return ExpoTemplate::getTemplate();
        }

        public static function Get($eCode,$eArgs = array()){
            $eCode = $eCode ? $eCode : '404';
            $func = null;
            $eArgs = array(
                'code'=>'404',
                'msg'=>'msg',
                'file'=>'file',
                'line'=>'line'
            );
            if($func){
                //call_user_func($func);
            }
            if($lib = @file_get_contents(dirname(__FILE__) . '/../error/error.json')){
                $lib = @utf8_encode($lib);
                $error = @json_decode($lib, true);
                $e['code'] = $error[$eCode]['code'];
                $e['msg'] = $error[$eCode]['message'];
                $e['file'] = $error[$eCode]['file'];
                $e['line'] = $error[$eCode]['line'];
                header("HTTP/1.0 404 Not Found");
                header('Content-Type: text/html');
                $template = self::expoTemplate();
                $template->__set("errCode",$e['code']);
                $template->__set("errMessage",$e['msg']);
                $template->__set("errFile",$e['file']);
                $template->__set("errLine",$e['line']);
                return $template->output('error');
            }else{
                echo 'error';
            }
        }

        public static function sError($e){
            header("HTTP/1.0 402 Not Working!");
            header('Content-Type: text/html');
            $error['code'] = $e->getCode();
            $error['msg'] = $e->getMessage();
            $error = <<<EOD
                <h1>Fatal Error: $error[code]</h1>
                <p>$error[msg]</p>
            EOD;
            return exit($error);
        }
    }
?>