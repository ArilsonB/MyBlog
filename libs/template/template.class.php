<?php
    /**
     * MYB Template Class
     * Version: 0.3
     * Powered By: Arilson Bolivar (TryUps Inc.)
     */
    require_once(dirname(__FILE__) . '/template.selected.php');
    require_once(dirname(__FILE__) . '/../sql/ExportDB.class.php');
    class Template extends themeConfig {
        protected $file;
        protected $filename;
        protected $varname;
        protected $template;
        protected $ext;
        protected $var;
        protected $value;
        protected $values;
        protected $conn;
        public $theme;
        public $getUrl;

        private static function connectDB(){
            return ExportDB::getDB();
        }
        public function __construct($template = 'simple',$ext = '.html'){
            $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
            $this->getUrl = "$protocol://$_SERVER[HTTP_HOST]";
            $this->style = themeConfig::Theme();
            $this->config = themeConfig::Settings();
            $this->conn = self::connectDB();
            $template = $this->config['theme'];
            $this->theme = $template;
            $template = dirname(__FILE__) . "/../..".DIRECTORY_SEPARATOR."global/templates/" . $template . "/";
            $this->template = $template;
            if(is_dir($template)):
                $this->ext = $ext;
            else:
                $error = array('type'=>0,'message'=>"Theme '$this->theme' not exists.",'file'=>$template,'line'=>0);
                $this->error($error);
            endif;
        }
        public function load($varname = '.',$filename = 'index.html'){
            $file = $this->template.$filename.$this->ext;
            if(!file_exists($this->template.'index.html') || !file_exists($this->template.'style.css')){
                $this->error("Template not valid.");
            }else{
                if($filename = @FILE_GET_CONTENTS($file)){
                    $this->setValue($varname,$filename);
                }else{
                    $error = error_get_last();
                    return $this->error($error);
                }
            }
        }
        private function addFile($varname, $filename){
            return $this->load(".",$filename);
        }

        public function __set($var, $value){
            return $this->setValue($var,$value);
        }

        public function setString($varname,$value){
            $this->values["%$varname%"] = $value;
        }

        protected function setValue($varname, $value) {
			$this->values["%$varname%"] = $value;
        }

        private function getVar($varname){
            if (!isset($this->values["%$varname%"])){
                $val = "";
            }else{
                $val = $this->values["%$varname%"];
            }
            return $val;
        }

        public function replaceVars(){
            $file = $this->getVar(".");
            foreach ($this->values as $var => $value) {
                $replace_var = $var;
                $file = str_replace($replace_var, $value, $file);
            }
            $this->setValue(".",$file);
        }

        public function replaceVar($file){
            $file = $file;
            foreach ($this->values as $var => $value) {
                $replace_var = $var;
                $file = str_replace($replace_var, $value, $file);
            }
            return $file;
        }

        public function includer(){
            $file = $this->getVar(".");
            $includer = array();
            preg_match_all("!<%include[^>]+'(.*?)'[^>]+%>!", $file, $includer);

            for ($i = 0; $i < count($includer[1]); $i++) {
                $extension = [".html",".htm",".php",".asp"];
                foreach($extension as &$ext){
                    $filename = $this->template.$includer[1][$i].$ext;
                    if(is_file($filename)){
                        $fileLoad = @file_get_contents($filename);
                        //$fileLoad = $this->output($includer[1][$i]);
                        $file = str_replace($includer[0][$i],$fileLoad,$file);
                        break;
                    }else{
                        continue;
                    }
                }
            }

            return $this->setValue(".",$file);
        }

        public function requirer(){
            $file = $this->getVar(".");
            $requirer = array();
            preg_match_all("!<%require[^>]+'(.*?)'[^>]+%>!", $file, $requirer);

            for ($i = 0; $i < count($requirer[1]); $i++) {
                $extension = [".php",".html",".htm",".asp"];
                foreach($extension as &$ext){
                    $filename = $this->template.$requirer[1][$i].$ext;
                    if(is_file($filename)){
                        ob_start();
                        @require $filename;
                        $fileLoad = ob_get_contents();
                        ob_end_clean();
                        $file = str_replace($requirer[0][$i],$fileLoad,$file);
                        break;
                    }else{
                        continue;
                    }
                }
            }
            return $this->setValue(".",$file);
        }

        public function getTitle(){
            $file = $this->getVar(".");
            $file = str_replace("\n","",$file);
            $reg = "@<%title left='(?'left'[^/]+)' center='(?'center'[^/]+)' right='(?'right'[^/]+)';%>@";
            preg_match_all($reg,$file,$m);
            if(count($m[0]) > 0){
                $left = $m['left'][0];
                $center = $m['center'][0];
                $right = $m['right'][0];
                $rep = "${left} ${center} ${right}";
                $file = str_replace($m[0],$rep,$file);
                return $file = $this->setValue(".",$file);
            }
        }

        public function getFunctions(){
            $file = $this->getVar(".");
            $file = str_replace("\n","",$file);
            $reg = "@<%get content='(?'content'[^/]+)';%>@";
            preg_match_all($reg,$file,$m);
            if(count($m[0]) > 0){
                $fun = "";
                $file = str_replace($m[0],$fun,$file);
                return $file = $this->setValue(".",$file);
            }
        }

        public function loadPosts(){
            $file = $this->getVar(".");
            $file = str_replace("\n","",$file);
            $reg = "@<!-- LOAD 'posts' -->\s*(\s*.*?\s*)<!-- ENDLOAD -->@";
            preg_match_all($reg,$file,$m);
            if(count($m[1]) > 0){
                $query = "SELECT * FROM posts ORDER BY id";
                $query = $this->conn->query($query);
                $rep = array();
                //while(false != ($row = $this->conn->fetchAssoc($query))){
                foreach($query as $row){
                    $post = $m[1][0];
                    $purl = $this->getUrl.@date("/Y/m/",strtotime($row["date"])).$row['name'].".html";
                    $pdate = @date("d/m/Y H:i",strtotime($row["date"]));
                    if($row["author"] > 0){
                        $pauthor = $this->conn->select('users','fullname',"id = $row[author]");
                    }else{
                        $pauthor= "MyBlog Team";
                    }
                    $varToRep = array("%post_title%","%post:url%","%post_date%","%post_author%","%post_exerpt%","%post_content%");
                    $varRep = array($row["title"],$purl,$pdate,$pauthor,$row["content_min"],$row["content"]);
                    $rep[] = str_replace($varToRep,$varRep,$post);
                }
                krsort($rep);
                $rep = $this->replaceVar($rep);
                $file = str_replace($m[1][0],implode("",$rep),$file);
                return $file = $this->setValue(".",$file);
            }
        }

        public function loadPost($type = 'post'){
            $file = $this->getVar(".");
            $file = str_replace("\n","",$file);
            $reg = "@<!-- LOAD 'post' -->\s*(\s*.*?\s*)<!-- ENDLOAD -->@";
            preg_match_all($reg,$file,$m);
            if (count($m[1]) > 0) {
                $id = isset($_GET["id"]);
                $uri = explode("/",$_SERVER['REQUEST_URI']);
                $date = $uri[1]."-".$uri[2];
                $date = @date("m/Y",strtotime($date));
                $postname = str_replace(".html","",$uri[3]);
                if(!$date || !$postname){
                    $error = array('type'=>0,'message'=>"This page '$postname' don't exist.",'file'=>0,'line'=>0);
                    $this->error($error);
                }else{
                    $query = "SELECT * FROM posts WHERE name='$postname' LIMIT 1";
                    $posts = $this->conn->query($query);
                    $rep = array();
                    //while (false != ($row = $this->conn->fetchAssoc($posts))){
                    foreach($posts as $row){
                        $pdate = @date("m/Y",strtotime($row["date"]));
                        if($date == $pdate){
                            $post['layout'] = $m[0][0];
                            $post['title'] = $row["title"];
                            $pdate = @date("d/m/Y H:i",strtotime($row["date"]));
                            if($row["author"] > 0){
                                $pauthor = $this->conn->select('users','fullname',"id = $row[author]");
                            }else{
                                $pauthor= "MyBlog Team";
                            }
                            $file = str_replace('%blogpage%',$row['title'],$file);
                            $varToRep = array("%post_title%","%post_date%","%post_author%","%post_exerpt%","%post_content%");
                            $varRep = array($row["title"],$pdate,$pauthor,$row["content_min"],$row["content"]);
                            $rep[] = str_replace($varToRep,$varRep,$post['layout']);
                        }else{
                            $error = array('type'=>0,'message'=>"This page '$postname' don't exist.",'file'=>0,'line'=>0);
                            $this->error($error);
                        }
                    }
                    krsort($rep);
                    if(empty($rep)){
                        $error = array('type'=>0,'message'=>"This page '$postname' don't exist.",'file'=>0,'line'=>0);
                        $this->error($error);
                    }
                    $file = str_replace($m[0][0],implode("",$rep),$file);
                    $file = $this->replaceVar($file);
                    return $file = $this->setValue(".",$file);
                }
            }
        }

        public function getCat($id = 0){

        }

        public function getSettings(){
            $this->setValue("styles:default",$this->getUrl . "/static/style.css");
        }

        public function clear($varname) {
			return $this->setValue($varname, "");
        }

        public function output($file){
            $this->load(".",$file);
            $this->includer();
            $this->includer();
            $this->requirer();
            $this->replaceVars();
            $this->getTitle();
            $this->getFunctions();
            $this->loadPosts();
            $this->loadPost();
            $this->getSettings();
        }
        public function error($e){
            header("HTTP/1.0 404 Not Found");
            $fe = @file_get_contents(dirname(__FILE__) . '/../error/error.html');
            $this->__set("errType",  $e['type']);
            $this->__set("errMessage",  $e['message']);
            $this->__set("errFile",  $e['file']);
            $this->__set("errLine",  $e['line']);
            $fe = $this->replaceVar($fe);
            $this->setValue(".",$fe);
        }
        public function __destruct(){
            echo $this->getVar(".");
        }
    }

?>