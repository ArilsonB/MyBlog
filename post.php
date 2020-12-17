<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
    require 'libs/class/posts.class.php';
    $uri = isset($_GET['posting']);
    if($uri){
        $post_title = $_POST['title'];
        $post_content = $_POST['content'];
        if($post_title || $post_content){
            Post::create($post_title,$post_content);
        }

    }

    if(isset($_GET['delete'])){
        $p_id = $_GET['delete'];
        Post::delete($p_id);
        echo $p_id;
    }
?>


<form action="?posting=true" method="post">
    <div>
        <label for="title">Post Title:</label>
        <input type="text" name="title" id="title">
    </div>
    <div>
        <label for="content">Post Content:</label>
        <textarea name="content" id="content"></textarea>
    </div>
    <input type="submit" value="Enviar">
</form>
<style>
*{
    margin:0;
    padding:0;
}
body {
    background: #e2e1e0;
    width:100%;
    height: 100%;
}
section {
    position:relative;
    float:left;
}

section > article {
    position:relative;
    float:left;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    border-radius: 5px;
    padding:10px;
    margin: 10px;
    width: 300px !important;
    height: 400px;
}

</style>
<section>
    <h1>Posts</h1>
    <?php
        Post::list($odd=0,function($row){
            echo<<<EOD
                <article>
                    <h2>$row[title]</h2>
                    <small>$row[date] <a href='?delete=$row[id]'>Apagar</a></small>
                    <p>$row[content_min]</p>
                </article>
            EOD;
        });
    ?>
</section>