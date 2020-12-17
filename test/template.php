<?php
  
  class Template {
    private $template;
    private $file;
    private $db;
    protected $values;

    private static function connectDB(){
      return false;
    }

    public function __construct($options = array("default"=>"index.html")){
      $this->db = self::connectDB();
    }

    private function set($name = "*", $value = null){
      return $this->values["{".$name."}"] = $value;
    }

    private function get($name){
      return $this->values["{".$name."}"];
    }

    public function __set($name,$value){
      return $this->set($name,$value);
    }

    public function __get($name){
      return $this->get($name);
    }

    private function load($file){
      $file = pathinfo($file,PATHINFO_FILENAME);
      $support = ['.html','.htm','.xhtml','.myb'];

      foreach($support as $ext){
        $filepath = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.$file.$ext);
        if(is_file($filepath)){
          return @file_get_contents($filepath);
        }
      }
      return false;
    }

    private function add($file){
      $file = pathinfo($file,PATHINFO_FILENAME);
      $support = ['.html','.htm','.xhtml','.php','.myb','.php5'];
      foreach($support as $ext){
        $filepath = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.$file.$ext);
        if(is_file($filepath)){
          ob_start();
          @require $filepath;
          $file = ob_get_contents();
          ob_end_clean();
          return $file;
        }
      }
      return false;
    }

    private function php($code = null){
      $file = $code ? $code : $this->get('*');
      $pattern = "#<php>(.*)</php>#s";
      if(preg_match_all($pattern, $file, $results, PREG_SET_ORDER)){
        foreach($results as &$php){
          ob_start();
            try {
              eval($php[1]);
            }catch(Throwable $t){
              echo<<<EOD
                <p class='myb__error_t'>$t</p>
              EOD;
            }
            $phpcode = ob_get_contents();
          ob_end_clean();
          if($phpcode){
            $file = str_replace($php[0],$phpcode,$file);
          }else{
            $file = str_replace($php[0],'<p class="myb__error_php_stat">Falied to add php statement.</p>',$file);
          }
        }
        return $this->set('*', $file);
      }
      return false;
    }

    private function import($file = null){
      $file = $file ? $file : $this->get('*');
      $pattern = "#import '(.*)';#";
      if(preg_match_all($pattern, $file, $results, PREG_SET_ORDER)){
        foreach($results as &$import){
          if($fileadd = $this->load($import[1])){
            $file = str_replace($import[0], $fileadd, $file);
          }else{
            $file = str_replace($import[0],"<p class='myb__error_imp'><h3>Error</h3>File '<em>$import[1]</em>' not found on 'import' statement.</p>",$file);
          }
        }
      }

      preg_match_all($pattern, $file, $results, PREG_SET_ORDER);

      if(empty($results)){
        return $this->set('*', $file);
      }else{
        return $this->import($file);
      }
    }

    private function require($file = null){
      $file = $file ? $file : $this->get('*');
      $pattern = "#require '(.*)';#";
      if(preg_match_all($pattern, $file, $results, PREG_SET_ORDER)){
        foreach($results as &$require){
          if($fileadd = $this->add($require[1])){
            $file = str_replace($require[0], $fileadd, $file);
          }else{
            $file = str_replace($require[0],"<p class='myb__error_req'><h3>Error</h3>File '<em>$require[1]</em>' not found on 'require' statement.</p>",$file);
          }
        }
      }

      preg_match_all($pattern, $file, $results, PREG_SET_ORDER);

      if(empty($results)){
        return $this->set('*', $file);
      }else{
        return $this->require($file);
      }
    }

    public function render($file = 'index.html',$var = '*'){
      if($file = $this->load($file)){
        return $this->set($var, $file);
      }
    }

    public function __destruct(){
      $this->import();
      $this->require();
      $this->php();

      return exit($this->get('*'));

    }

    public static function error($e){

    }
  }

?>