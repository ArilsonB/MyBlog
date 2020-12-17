<?php
    use MyB\User as User;
    use MyB\Sql as DB;
    require_once(dirname(__FILE__) . '/../../libs/class/user.class.php');
    require_once(dirname(__FILE__) . '/../../libs/sql/pdo.class.php');
    $user = new User();
    if($user->session()):
        include 'header.php';

        switch($req['params'][0]){
            case 'post':
                require('pages/post.php');
            break;
            default:
                require('pages/home.php');
            break;
        }

        include 'footer.php';
    else:
		header("Location: $URL/login?go=/dash");
	endif;
?>