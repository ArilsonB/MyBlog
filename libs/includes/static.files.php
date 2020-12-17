<?php
    $file = $data['params'][0];
    $ext = $extensao = pathinfo($file, PATHINFO_EXTENSION);
    switch($ext){
        default:
            return Error::Get('404');
        break;
        case 'css':
            header('Content-Type: text/css');
        break;
        case 'jpg':
            header('Content-type: image/jpeg');
        break;
        case 'png':
            header('Content-Type: image/png');
        break;
        case 'js':
            header('Content-Type: text/javascript');
        break;
    }
    if($file = @file_get_contents(realpath('./global/templates/simple/' . $file))){
        return exit($file);
    }else{
        return Error::Get('404');
    }
?>