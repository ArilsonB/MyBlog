<?php
    $blogdesc = $sql->select("preferences","value","name = 'blog_desc'","*");
    $template->blogpage = $blogdesc;
    echo $template->output("index");
?>