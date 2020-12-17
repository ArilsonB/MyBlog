<?php
    if(isset($_POST["username"]) && isset($_POST["password"])){
        require_once(dirname(__FILE__) . '/../class/user.class.php');
        $username = $_POST["username"];
        $password = $_POST["password"];
        $user = new User();
        $user->login($username,$password);
    }
?>