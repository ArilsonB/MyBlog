<?php
    require_once(dirname(__FILE__) . '/../sql/ExportDB.class.php');
    class Post {
        private static $uid = 0;
        private static $db;
        private static function connectDB(){
            return ExportDB::getDB();
        }
        public static function create($title,$content){
            $db = self::connectDB();
            $name = self::pName($title);
            echo $name;
            if(empty($name)){
                die('error');
            }
            $posts = array(
                'title'=>$title,
                'content_min'=>$content,
                'content'=>$content,
                'date'=>@date('Y-m-d H:i:s'),
                'name'=>$name
            );
            $db->insert('posts',$posts);
        }
        private static function edit(){
            return false;
        }
        public static function delete($id){
            $db = self::connectDB();
            if($query = $db->query("DELETE FROM `posts` WHERE id = $id")){
                echo 'Deletado: '.$id;
            }
        }
        public static function pName($str){
            $str = preg_replace('@%(.*?)%@', '', $str, -1);
            $str = preg_replace('/[áàãâä]/ui', 'a', $str);
            $str = preg_replace('/[éèêë]/ui', 'e', $str);
            $str = preg_replace('/[íìîï]/ui', 'i', $str);
            $str = preg_replace('/[óòõôö]/ui', 'o', $str);
            $str = preg_replace('/[úùûü]/ui', 'u', $str);
            $str = preg_replace('/[ç]/ui', 'c', $str);
            //$str = preg_replace('/[,(),;:|!"#$%&/?~^><ªº-]/', '-', $str);
            $str = preg_replace('/[^a-z0-9]/i', '-', $str);
            $str = preg_replace('/_+/', '-', $str);
            $str = str_replace('--','-', $str);
            if(substr($str, 0, 1) == '-'){
                $str = substr($str, 1);
            }
            if(substr($str, -1) == '-'){
                $str = substr($str, 0, -1);
            }
            $str = str_replace('--','-', $str);
            return $str;
        }

        /* List */
        public static function list($oder,$function = null){
            $db = self::connectDB();
            $eq = $db->query('SELECT * FROM `posts` LIMIT 10');
            foreach($eq as $row){
                if($function){
                    call_user_func($function,$row);
                }
            }
        }
    }
?>