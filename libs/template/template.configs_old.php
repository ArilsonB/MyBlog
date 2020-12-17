<?php

    $blogtitle = $sql->select("preferences","value","name = 'blog_name'");
    $templateN = $sql->select("preferences","value","name = 'blog_template'");
    $blogurl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $blogurlUp = $sql->query("UPDATE preferences SET value = '$blogurl' WHERE name = 'blog_url'");
    $template->conn = "";
    $template->blogtitle = $blogtitle;
    $template->blogdesc = $sql->select("preferences","value","name = 'blog_desc'","*");
    $template->blog_url = $blogurl;
    $template->template_style = $blogurl . "/global/templates/" . $templateN . "/style.css";
    $template->js_folder = $blogurl . "/global/templates/" . $templateN . "/assets/js/";

    /* Styles */
    $template->__set("styles",$blogurl . "/static/assets/css/");
    $template->__set("styles:default",$blogurl . "/static/style.css");

    /* Javascripts */
    $template->__set("scripts",$blogurl . "/static/assets/js/");
    
    /* Urls */
    $template->__set("url:blog", $blogurl);
    $template->__set("url:home", $blogurl);


?>