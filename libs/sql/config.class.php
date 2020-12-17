<?php
    namespace Myb;
    class Config {
        var $settings;
        public function Settings(){
            $settings['host'] = 'localhost';
            $settings['user'] = 'root';
            $settings['pass'] = 'root';
            $settings['db'] = 'MyBlog';
            $settings['charset'] = 'utf8';
            return $settings;
        }
    }
?>