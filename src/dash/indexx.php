<?php
	require_once("../libs/sql/conn.class.php");
	include("./pages/header.php");
	include("./pages/sidebar.php");
?>
	<main class="main-load">
		<header>
			<div class="header-left">
				<h1>Welcome to MyBlog</h1>
				<p>Hello %user%, welcome to your new MyBlog website.</p>
			</div>
		</header>
		<section>
			<div class="box boxed-2">
				<h3 class="box-title">Meu MyBlog</h3>
			</div>
			<div class="box boxed">
				<h3 class="box-title">Novidades</h3>
			</div>
			<div class="box boxed-3">
				<h3 class="box-title">Hoje</h3>
			</div>
			<div class="box">
				<h3 class="box-title1">Trabalhos</h3>
			</div>		
			<div class="box">
				<h3 class="box-title1">Ultimas Postagens</h3>
			</div>
			<div class="box">
				<h3 class="box-title1">Estatisticas</h3>
			</div>
		</section>
		<footer>
			<div class="col">
				<h4>Links Externos</h4>
				<ul>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
				</ul>
			</div>
			<div class="col">
				<h4>Meu MyBlog</h4>
				<ul>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
				</ul>
			</div>
			<div class="col">
				<h4>a</h4>
				<ul>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
					<li><a href="">Link</a></li>
				</ul>
			</div>
			<div class="footer-copy">
				Open source made with ♥︎
			</div>
		</footer>
	</main>
<?php
	include("./pages/footer.php");
?>