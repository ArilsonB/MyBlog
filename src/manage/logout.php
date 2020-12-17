<?php
    use MyB\User as User;
    require_once(dirname(__FILE__) . '/../../libs/class/user.class.php');
    $user = new User();
    $user->logout();
?>