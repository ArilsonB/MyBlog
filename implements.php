<?php
    $package = @file_get_contents("package.json");
    $package = @json_decode($package, true);
    define("PACKAGE", $package);
    define("VERSION",PACKAGE['version']);
    define("MODE","development");
    $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    define("URL","$protocol://$_SERVER[HTTP_HOST]");
?>