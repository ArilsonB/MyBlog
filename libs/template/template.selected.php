<?php
    class themeConfig {
        var $config;
        public function Settings(){
            $config['theme'] = 'simple';
            return $config;
        }
        public function Theme(){
            $this->__set("styles:default","$this->getUrl/static/style.css");
            $this->__set("styles","$this->getUrl/static/css/");
            $this->__set("scripts","$this->getUrl/static/js/");
            $this->__set("version","1.0");
            $this->__set("blog:title","MyBlog");
            $this->__set("blog:url",$this->getUrl);

            @session_start();
            if(isset($_SESSION['user'])){
                $this->__set("user",$_SESSION['user']);
            }else{
                $this->__set("user",'User');
            }
        }
    }

?>