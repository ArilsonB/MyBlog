<?php
    require(dirname(__FILE__) . '/template.class.php');
    class ExpoTemplate {
        private static $template;

        public static function getTemplate(){
            self::$template = new Template();
            return self::$template;
        }
    }
?>