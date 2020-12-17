<?php
    use MyB\Routes as Routes;
    use MyB\Error;

    require_once(dirname(__FILE__) . '/../class/error.class.php');
    require_once(dirname(__FILE__) . '/../class/routes.class.php');

    Routes::init();

    Routes::static('/static',realpath('./global/templates/simple'));
    
    Routes::group('/dash',include realpath('./src/manage/dash.router.php'));
    Routes::static('/dash',realpath('./src/manage/'));
    
    Routes::post('/req_login',function(){
        require_once(dirname(__FILE__) . '/../private/login.lib.php');
    });
    Routes::add('/post', function($res){
        require_once(dirname(__FILE__) . '/../post/post.php');
    },['post','get']);

    // Api routes

   /* Routes::group('/api/:id',[
        'Home' => ['(|\/)',function($req){
            echo 'home';
        }],
        'Set' => ['/settings/:sola',function($req){
            print_r($req);
            echo 'settings';
        }]
    ]);*/

    Routes::run();
