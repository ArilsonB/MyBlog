<?php
    namespace Myb;
    require(dirname(__FILE__) . '/../class/template.class.php');
    class ExpoTemplate {
        private static $template;

        public static function getTemplate(){
            self::$template = new Template();
            return self::$template;
        }
    }
?>