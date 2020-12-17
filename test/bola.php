<h1>Teste</h1>
<?php
    error_reporting(0);
    $pattern = "/:[a-zA-Z0-9]+/";
    $string = "Me proteja eu quero mergulhar, o seu corpo encantar. :about/as/:put";

    preg_match_all($pattern, $string, $matches);
    var_dump($matches);

?>