<?php
    require_once(dirname(__FILE__) . '/config.class.php');
    class Sql extends Config {
        const config = true;
        protected $host;
        protected $user;
        protected $pass;
        public $conn;

        public function __construct($host='localhost',$user='root',$pass='root',$db='MyBlog',$type='mysql',$charset='utf-8'){
            $this->settings = Config::Settings();
            $this->host = $this->settings['host'];
            $this->user = $this->settings['user'];
            $this->pass = $this->settings['pass'];
            $this->db = $this->settings['db'];
            $this->charset = $this->settings['charset'];
            $connect = sprintf('%s:host=%s;dbname=%s;charset=%s', $type, $this->host, $this->db, $this->charset);
            $this->pdo = new PDO($connect,$this->user,$this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function query($sql){
            try {
                if($sql = $this->pdo->prepare($sql)){
                    $sql->execute();
                    return $sql;
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function select($table,$value,$where,$refer = '*'){
            if(!$where){
                $sql = "SELECT $refer FROM $table";
            }else{
                $sql = "SELECT $refer FROM $table WHERE $where";
            }
            $sql = $this->query($sql);
            if($row = $this->fetchAssoc($sql)){
                return $row[$value];
            }
        }

        public function select2($table,$value,$where=null,$refer='*'){
            if(!$where){
                $sql = "SELECT $refer FROM $table";
            }else{
                $sql = "SELECT $refer FROM $table WHERE $where";
            }
            $query = $this->query($sql);
            foreach($query as $row){
                return $row[$value];
            }
        }

        public function insert($tb,$values = array()){
            try {
                $iName = array();
                foreach($values as $insertName => $insertVal){
                    array_push($iName,$insertName);
                }
                $abd = implode(",",$iName);
                $vals = ":".implode(", :",$iName);
                $total = count($iName);
                $sql = "INSERT INTO `$tb` ($abd) VALUES ($vals)";
                if($query = $this->pdo->prepare($sql)){
                    /*foreach($values as $insertName => $insertVal){
                        $query->bindParam("s",$insertVal,PDO::PARAM_STR);
                    }*/
                    $query->execute($values);
                }
            }catch(PDOException $e){
                echo 'PDO Exception Caught. '.$e->getCode();
		        echo 'Error with the database: <br />';
		        echo 'SQL Query: ', $sql;
		        echo '<br>Error: ' . $e->getMessage();
		        return $e->getMessage();
            }
        }

        public function update($tb,$where=1,$values = array()){
            try {
                $iName = array();
                foreach($values as $insertName => $insertVal){
                    array_push($iName,$insertName);
                }
                $vals = ":".implode(",",$iName."= :".$iName);
                $total = count($iName);
                $sql = "UPDATE `$tb` SET $vals WHERE id = $where";
                if($query = $this->pdo->prepare($sql)){
                    /*foreach($values as $insertName => $insertVal){
                        $query->bindParam("s",$insertVal,PDO::PARAM_STR);
                    }*/
                    $query->execute($values);
                }
            }catch(PDOException $e){
                echo 'PDO Exception Caught. '.$e->getCode();
		        echo 'Error with the database: <br />';
		        echo 'SQL Query: ', $sql;
		        echo '<br>Error: ' . $e->getMessage();
		        return $e->getMessage();
            }
        }

        public function delete(){
            
        }

        public function fetchAll($result){
            return $result->fetchAll();
        }
        
        public function fetchAssoc($result){
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        public function numRows($result){
            return $result->fetch(PDO::FETCH_NUM);
        }

        public function preference($prefname){
            $sql = "SELECT value FROM preferences WHERE name = '$prefname'";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            if($row = $sql->fetch(PDO::FETCH_ASSOC)){
                return $row["value"];
            }
        }

    }
?>