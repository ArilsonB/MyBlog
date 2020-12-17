<?php
    session_start();
    if(isset($_SESSION['id'])){
        header('Location: ./dash');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dash/css/login.css">
</head>
<body>
    <div class="box">
        <form action="../libs/post/login.php" method="POST">
            <h2>Login – MyBlog</h2>
            <input type="text" name="username" id="usr" placeholder="Username">
            <input type="password" name="password" id="pas" placeholder="Password">
            <input type="submit" value="Signin">
        </form>
    </div>
</body>
</html>