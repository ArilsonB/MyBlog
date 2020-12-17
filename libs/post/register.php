<?php
session_start();
$user = preg_replace('/[^[:alpha:]_]/', '', $_SESSION['REG_USR']);
$email = filter_var($_SESSION['REG_MAIL'], FILTER_VALIDATE_EMAIL);
$pass = preg_replace('/[^[:alnum:]_]/', '',$_SESSION['REG_PASS']);
$fname = $_SESSION['REG_FNAME'];
$lname = $_SESSION['REG_LNAME'];
$birth = $_SESSION['REG_BIRTH'];
if($user || $email || $pass || $fname || $lname || $birth){
    require_once(dirname(__FILE__) . '/../class/user.class.php');
    $userc = new User();
    $user = $userc->sanitize($user);
    $pass = $userc->sanitize($pass);
    $fullname = $userc->sanitize($fname.' '.$lname);
    if($userc->register($user,$email,$pass,$fullname,$birth)){
        unset($_SESSION);
        session_destroy();
        echo 'logging...';
        $userc->login($user,$pass);
    }else{
        //TODO: Add myb errors
        echo 'FATAL ERROR!';
        unset($_SESSION);
        session_destroy();
    }
}else{
    //TODO: Add myb errors
    unset($_SESSION);
    session_destroy();
}

?>