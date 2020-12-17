<?php
    namespace Myb;
    require_once(dirname(__FILE__) . '/../sql/ExportDB.class.php');
    class themeConfig {
        var $config;
        protected $conn;
        private static function connectDB(){
            return ExportDB::getDB();
        }
        public function Settings(){
            $conn = self::connectDB();
            $config['theme'] = $conn->select("preferences","value","name = 'blog_template'");
            return $config;
        }
        public function Theme(){
            $conn = self::connectDB();
            $this->__set('blog:title', $conn->select("preferences","value","name = 'blog_name'"));
            $this->__set('blog:desc', $conn->select("preferences","value","name = 'blog_desc'"));
            $this->__set('blog:description', $conn->select("preferences","value","name = 'blog_desc'"));
            $this->__set('blog:url', $this->getUrl);
            $this->__set('aa','aaa');
            $this->__set("styles:default", $this->getUrl."/static/style.css");
            $this->__set("version","1.0");
            
        }
    }

?>