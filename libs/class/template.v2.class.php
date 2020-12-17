<?php

namespace MyB;

/**
 * @Version: 1.1.0
 */

class Template {
    const VERSION = '1.1.0';
    protected $file;
    private $filename;
    private $var;
    private $db;
    protected $theme;
    protected $values = array();
    protected $includes = array();

    private static function connectDB(){
        return false;

    }

    public function __construct($options = array()){

        $this->db = self::connectDB();
        $this->start_time = microtime(true);
        $this->theme = 'simple';
    }

    public function setDir($dir){
        $this->dir = $dir;
    }

    private function load($var,$file){
        if( file_exists($file) && is_readable($file) ) {
            $file = file_get_contents($file);
            return $this->setValue($var,$file);
        }else{
            trigger_error("$file not exists!", E_USER_ERROR);
        }
    }

    public function add($var = '*', $file){
        return $this->load($var,$file);
    }

    public function __set($var,$value){
        $this->values['{'.$var.'}'] = $value;
        return $value;
    }

    public function __get($var){
        return $this->values['{'.$var.'}'];
    }

    public function __call($function, $args){
        print_r($args);
    }

    public function __invoke(){
        return false;  
    }

    public function setValue($var,$value){
        $this->values['{'.$var.'}'] = $value;
        return $value;
    }

    public function getValue($var){
        return $this->values['{'.$var.'}'];
    }

    public function replaceVars($var = '*'){
        $file = $this->getVar($var);
        foreach ($this->values as $var => $value) {
            $replace_var = $var;
            $file = str_replace($replace_var, $value, $file);
        }
        $this->setValue($var,$file);
    }

    public function block($blockname = '.', $function = null){
        $blockname = 'posts';
        $file = $this->file;
        $pattern = '#{block[^>]+name=[^>]+posts[^>]+}(.*?){/block}#s';
        preg_match_all($pattern,$file,$match);
        $rep = str_replace('{post:name}',call_user_func($function),$match[1][0]);
        $rep = preg_replace($pattern,$rep, $file);
        $this->setValue('*',$rep);
    }

    private function replaceBlocks($blockname = '.'){

    }

    private function loops(){
        $pattern = '{loop}\s*(\s*.*?\s*){/loop}';
    }

    public function exists($var){
        return in_array($var, $this->values);
    }

    public function clear($var){
        $this->setValue($var,'');
    }

    public function include(){
        return false;
    }

    public static function merge($content, $separator = "n"){

    }

    public function display($var = '*'){
        return $this->getValue($var);
    }

    public function compile(){
        return $this->load("*","test.html");
    }

    public function render($file = 'blank.html'){
        $this->load('*',$file);
        $this->file = $this->getValue('*');
    }

    public function error($e = array()){
        return $e;
    }

    public function __destruct(){
        return exit($this->display());
    }
}