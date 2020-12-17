<?php
    
    require_once("./libs/sql/conn.class.php");
    $maintening = $sql->select("preferences","value","name = 'maintenance'","*");
    if(isset($maintening) > 1){
        die("Maintening...");
    }
    $template = $sql->select("preferences","value","name = 'blog_template'","*");
    define("TEMPLATE",$template);
    require_once("./libs/class/blog.class.php");
?>