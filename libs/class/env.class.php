<?php
    class Env {
        public function setEnv($env = 'development'){
            $this->env = $env;
            return $env;
        }
        public function getEnv(){
            return $this->env;
        }
    }
?>