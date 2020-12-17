<?php
    /*
     * Mysqli DB 
    */

    require_once(dirname(__FILE__) . '/config.class.php');
    class Sql extends Config {
        const config = true;
        protected $host;
        protected $user;
        protected $pass;
        protected $db;
        public $conn;

        public function __construct($host = 'localhost', $user = 'root', $pass = '', $db = 'MyBlog', $charset = 'utf8'){
            $this->settings = Config::Settings();
            $this->host = $this->settings['host'];
            $this->user = $this->settings['user'];
            $this->pass = $this->settings['pass'];
            $this->db = $this->settings['db'];
            $this->charset = $this->settings['charset'];
            $this->mysqli = new mysqli($this->host,$this->user,$this->pass,$this->db);
            if ($this->mysqli->connect_error) {
                $this->error('Failed to connect to MySQL - ' . $this->mysqli->connect_error);
            }
            $this->mysqli->set_charset($this->charset);
        }

        public function query($sql){
            if(!$sql){ $this->error("Query Error!"); }
            if($result = $this->mysqli->query($sql)){
                return $result;
            }
        }

        public function select($table,$value,$where,$refer = '*'){
            if(!$where){
                $sql = "SELECT $refer FROM $table";
            }else{
                $sql = "SELECT $refer FROM $table WHERE $where";
            }
            if($result = $this->mysqli->query($sql)){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                return $row[$value];
            }
        }

        public function insert(){

        }

        public function update(){

        }

        public function delete(){
            
        }

        public function fetchAssoc($result){
            return $result->fetch_assoc();
        }

        public function fetchArray($result, $type = MYSQLI_ASSOC){
            return $result->fetch_array($type);
        }

        public function fetchAll($result, $type = MYSQLI_ASSOC){
            return $result->fetch_all($type);
        }

        function fetchRow($result){
		    return $result->fetch_row();
        }

        public function numRows($result){
            return $result->num_rows;
        }

        function lastInsertedID(){
            return $this->mysqli->insert_id;
        }
        
        function escapeString($query){
		    return $this->mysqli->escape_string($query);
	    }

        function freeResult($result){
		    $this->mysqli->free_result($result);
	    }


        public function preference($prefname){
            $sql = "SELECT value FROM preferences WHERE name = '$prefname'";
            $result = mysql_query($this->conn,$sql);
            if($result === FALSE) { 
                return mysqli_error();
            }else{
                $row = mysqli_fetch_assoc($result);
                return $row["value"];
            }
    
        }

        function close(){
            return $this->mysqli->close();
        }

        public function error($e){
            exit($e);
        }

        public function __destruct(){
            if($this->mysqli != null){
                $this->mysqli->close();
                $this->mysqli = null;
            }
        }

    }
?>