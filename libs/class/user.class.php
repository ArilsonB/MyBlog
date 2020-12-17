<?php

namespace Myb;

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
            header('Content-Type: application/json');
            if($login = $this->conn->query("SELECT * FROM `users` WHERE user = '$username' OR email = '$username'")){
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
                        $return = array(
                            'Logged' => true,
                            'user' => $row['user'],
                            'redirect' => "/dash"
                        );
                        http_response_code(200);
                        echo json_encode($return);
                    }else{
                        $error = array(
                            'code' => '0',
                            'message' => "Incorrect password, $username!",
                            'file' => '0',
                            'line' => '0'
                        );
                        http_response_code(404);
                        echo json_encode($error);
                    }
                }else{
                    $error = array(
                        'code' => '0',
                        'message' => "User not found, $username!",
                        'file' => '0',
                        'line' => '0'
                    );
                    http_response_code(404);
                    echo json_encode($error);
                }
            }
            /*else{
                header('Content-Type: application/json');
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
            }*/

        }else{
            return false;
        }
    }
    function register($username,$email,$password,$fullname,$birth){
    
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

    function info($info){
        $info = $_SESSION[$info];
        return $info;
    }

    function session(){
        @session_start();
        if(isset($_SESSION['auth']) && $_SESSION['auth'] == true){
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

    function logout(){
        @session_start();
        unset($_SESSION);
        @session_destroy();
        header('Location: http://test.myblog.dot/');
    }
}

?>