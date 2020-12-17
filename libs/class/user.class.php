<?php

require_once(dirname(__FILE__) . '/../sql/ExportDB.class.php');

class User {
    private $user;
    private $pass;

    private static function connectDB(){
        return ExportDB::getDB();
    }

    public function __construct(){
        $this->conn = self::connectDB();
    }

    function login($username, $password){
        if($this->session() === true){
            $this->logout();
        }
        if(!empty($username) && !empty($password)){
            if($login = $this->conn->query("SELECT * FROM `users` WHERE user = '$username'")){
                $row = $this->conn->fetchAssoc($login);
                if((int) $row > 0){
                    $pass = $row['pass'] ?? 'default';
                    if($this->pass_verify($password, $pass)){
                        @session_start();
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['user'] = $row['user'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['rank'] = $row['rank'];
                        $_SESSION['auth'] = [ 'time' => time(), 'ip' => $_SERVER['REMOTE_ADDR'], 'uAgent' => $_SERVER['HTTP_USER_AGENT'],'logged' => true];
                        header("Location: https://$_SERVER[HTTP_HOST]/dash");
                    }else{
                        echo "Incorrect password, $username!";
                    }
                }else{
                    echo "User not found, $username!";
                }
            }else{
                if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $username)) {
                    if($login = $this->conn->query("SELECT * FROM `users` WHERE email = '$username'")){
                        $row = $this->conn->fetchAssoc($login);
                        if((int) $row > 0){
                            $pass = $row['pass'] ?? 'default';
                            if($this->pass_verify($password, $pass)){
                                @session_start();
                                $_SESSION['id'] = $row['id'];
                                $_SESSION['user'] = $row['user'];
                                $_SESSION['email'] = $row['email'];
                                $_SESSION['rank'] = $row['rank'];
                                $_SESSION['auth'] = [ 'time' => time(), 'ip' => $_SERVER['REMOTE_ADDR'], 'logged' => true];
                                header("Location: https://$_SERVER[HTTP_HOST]/dash");
                            }else{
                                echo "Incorrect password, $username!";
                            }
                        }else{
                            echo "User not found, $username!";
                        }
                    }
                }else{
                    echo 'invalid email';
                }
            }

        }else{
            return "#0x8a4nP";
        }
    }
    function register($user,$email,$pass,$fullname,$birth){
        $pass = $this->password($pass);
        $birth = DateTime::createFromFormat('d/m/Y',$birth);
        $birth = $birth->format('Y-m-d');
        $regdate = date("Y-m-d H:i:s");
        $arrU = array(
            'user'=>$user,
            'email'=>$email,
            'pass'=>$pass,
            'fullname'=>$fullname,
            'birthdate'=>$birth,
            'registered'=>$regdate,
            'status'=>'0',
            'rank'=>'0'
        );
        if($this->conn->insert('users',$arrU)){
            return true;
        }else{
            return false;
        }
        
    }
    private function password($pass){
        $pass = password_hash($pass,PASSWORD_ARGON2ID);
        return $pass;
    }
    private function pass_verify($password,$pass){
        $pass = password_verify($password, $pass);
        return $pass;
    }
    private function verify($hash){
        // user verify acc hash
    }

    public function session(){
        @session_start();
        if(isset($_SESSION['auth']['logged'])){
            if($_SESSION['auth']['ip'] !== $_SERVER['REMOTE_ADDR']){
                session_destroy();
                header("Location: http://myblog.dot/login");
                return false;
            }else{
                if($_SESSION['auth']['time'] < time() - 300){
                    session_regenerate_id(true);
                    $_SESSION['auth']['time'] = time();
                    $_SESSION['auth']['ip'] = $_SERVER['REMOTE_ADDR'];
                }
                return true;
            }
        }else{
            return false;
        }
    }

    private function logout(){
        @session_start();
        unset($_SESSION);
        @session_destroy();
    }

    public function sanitize($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }


}

?>