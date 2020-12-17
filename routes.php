<?php
    require_once('libs/class/error.class.php');
    require_once('libs/class/routes.class.php');
    Routes::init();
    Routes::add('/att', function(){
        echo 'att';
    });

?>