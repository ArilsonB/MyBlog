<?php
    use MyB\Sql;
    require_once('libs/sql/pdo.class.php');
    if(isset($_GET['user'])){
        $user = $_GET['user'];
        $users = array();
        $db = new Sql();
        $q = $db->query("SELECT * FROM `users` WHERE user = '$user' OR email = '$user' LIMIT 1");
        foreach($q as $u){
            extract($u);
            $user = array(
                "fullname" => $fullname
            );
            array_push($users, $user);
        }
        http_response_code(200);
        echo json_encode($users);
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No acc found.")
        );
    }
?>