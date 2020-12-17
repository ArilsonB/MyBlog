<?php
    require dirname(__FILE__) . '/../class/posts.class.php';
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

<section>
    <h1>Posts</h1>
    <?php
        $abs = $res['template']->replaceVar('<h1>%version%</h1>');
        $ab = array();
        $ab['ab'] = $abs;
        Post::list($ord='a',function($row){
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