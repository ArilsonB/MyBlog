<?php
    namespace Myb;
    use \PDO;
    use \PDOException;
    use MyB\Error;
    require_once(dirname(__FILE__) . '/../class/error.class.php');
    require_once(dirname(__FILE__) . '/config.class.php');
    class Sql extends Config {
        const config = true;
        private $pdo;
        private $host;
        private $user;
        private $pass;
        public $conn;

        public function __construct($host='localhost',$user='root',$pass='root',$db='MyBlog',$type='mysql',$charset='utf-8'){
            $this->settings = Config::Settings();
            $this->host = $this->settings['host'];
            $this->user = $this->settings['user'];
            $this->pass = $this->settings['pass'];
            $this->db = $this->settings['db'];
            $this->charset = $this->settings['charset'];
            $connect = sprintf('%s:host=%s;dbname=%s;charset=%s', $type, $this->host, $this->db, $this->charset);
            try{
                $this->pdo = new PDO($connect,$this->user,$this->pass);
            }catch(PDOException $e){
                return Error::sError($e);
            }
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function query($sql){
            try {
                if($sql = $this->pdo->prepare($sql)){
                    $sql->execute();
                    return $sql;
                }
            }catch(PDOException $e){
                return Error::sError($e);
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

        public function sup_query($table,$values,$mod = 'AND'){
            $re = array();
            foreach($values as $val => $rep){
                $re[] = $val . " = '" . $rep . "'";
            }
            $re = implode(" $mod ",$re);
            try{
                $sql = "SELECT * FROM `$table` WHERE $re";
                if($sql = $this->pdo->prepare($sql)){
                    $sql->execute();
                    return $sql;
                }
            }catch(PDOException $e){
                return Error::sError($e);
            }
        }

        public function sup_select($table,$values,$single = true){
            $query = $this->sup_query($table,$values);
            if($row = $this->fetchAssoc($query)){
                return $row;
            }else{
                return 'nothing';
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

        public function update(){

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