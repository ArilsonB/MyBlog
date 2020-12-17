<?php
    return [
        'Home' => ['(|\/)',function($req){
            $file = dirname(__FILE__) . "/../../src/manage/index.php";
            require_once($file);
        }],
        'Home_Extended' => ['/([a-zA-Z0-9-_]+)', function($req){
            $file = dirname(__FILE__) . "/../../src/manage/index.php";
            require_once($file);
        },['get','post']],
        'Save' => ['/save_post', function($req){
            echo 'saved';
        },['post']],
    ];
?>