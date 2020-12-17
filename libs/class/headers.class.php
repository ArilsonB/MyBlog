<?php
    if($package = @file_get_contents(dirname(__FILE__) . "/../../package.json")){
        $package = @utf8_encode($package);
        $package = @json_decode($package, true);
        define("PACKAGE", $package);
        define("VERSION",PACKAGE['version']);
    }else{
        header("HTTP/1.0 404 Not Found");
        $error = error_get_last();
        $e = $error['message'];
        $fe = @file_get_contents(dirname(__FILE__) . '/../error/error.html');
        $e = sprintf($fe, $e);
        exit($e);
    }
    define("MODE","development");
    $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
    define("URL","$protocol://$_SERVER[HTTP_HOST]");
    //error_reporting(E_ALL ^ E_NOTICE);
?>