<?php
    require_once(dirname(__FILE__) . '/pdo.class.php');
    class ExportDB {
        private static $sql;

        public static function getDB(){
            self::$sql = new Sql();
            return self::$sql;
        }
    }
?>