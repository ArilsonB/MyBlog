<?php
    session_start();
    require_once(dirname(__FILE__) . "/../../libs/class/headers.class.php");
    require_once(dirname(__FILE__) . "/../../libs/class/user.class.php");
    $URL = URL;
	$user = new User();
	if ($user->session()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>White Glance</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/dash/reset.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/dash/style.css">
    <script src="https://kit.fontawesome.com/4b2d52ee6a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/zwppc1ipmvi8rdv1272l1ypq7247ou5hy64z7rzeik3iyaya/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
    <script>
    tinymce.init({
      selector: '#mytextarea'
    });
  </script>
</head>
<body>
    <header>
        <div class="top-header">
            <div class="left">
                <a href="http://"><h1>MyBlog</h1></a>
            </div>
            <div class="right"></div>
        </div>
        <nav>
            <ul>
                <li>
                    <a href=""><i class="fas fa-bars"></i></a>
                    <a href="">MyBlog</a>
                    <a href="">Novo</a>
                    <a href="">Estatisticas</a>
                    <a href="">Ajuda</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <aside></aside>
        <section>
            <p>
                <textarea name="" id="mytextarea"></textarea>
            </p>
            <article class="box big-box" id="come-home">
                <div class="box-title">
                    <h1>Box Title 1</h1>
                </div>
                <div class="box-content">
                    <p>Hello World !</p>
                </div>
            </article>
        </section>
    </main>
    <script src="global-panel-1.0.js"></script>
</body>
</html>
<?php
	}else{
		header("Location: $URL/login?go=/dash");
	}
?>