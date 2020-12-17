<?php
    require_once(dirname(__FILE__) . '/../class/error.class.php');
    $error = new MybError();
    $error->get('404');
?>