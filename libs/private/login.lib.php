<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    use MyB\User as User;
    if(isset($_POST["username"]) && isset($_POST["password"])){
        require_once(dirname(__FILE__) . '/../class/user.class.php');
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = new User();
        $user->login($username,$password);
    }
?>