<?php

    use MyB\User as User;
    require_once(dirname(__FILE__) . '/../../libs/class/headers.class.php');
    require_once(dirname(__FILE__) . '/../../libs/class/user.class.php');

    $user = new User();
    if($user->session()):
        header("Location: $URL/dash?origin=/login");
    else:
?>
<link rel="stylesheet" href="dash/login.css">
<body class='fast_container'>
    <main class='container'>
        <section class='box login-box myb__login-box'>
            <div class='login-header'>
                <h1>Login</h1>
            </div>
            <form action="./lib/private/login.lib.php" method="post" class="myb__login-form">
                <label>
                    <h2><!--<label for="stuff" class="fa fa-user"></label>--></h2>
                </label>
                <div class='user'>
                    <input type="text" name="username" id="umail" class='umail' required>
                    <label for="username">Username or Email Address</label>
                </div>
                <div class="pass">
                    <input type="password" name="password" class='upass' required>
                    <label for="password">Your Password</label>
                </div>
                <input type="hidden" name="origin" value="$MYB___origin_$websiteUrl">
                <button class='submit' disabled>Sign in</button>
            </form>
            <p class='myb__infos'></p>
        </section>
    </main>
    <script src="dash/js/login.lib.js"></script>
</body>
</html>
<?php
endif;
?>