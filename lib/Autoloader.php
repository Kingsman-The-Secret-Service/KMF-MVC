<?php

namespace KMF;

Class Autoloader{
    
    protected  $registry;
            
    function __construct($registry) {
        
        $this->registry = $registry;
        spl_autoload_register(array($this,'model'));
        spl_autoload_register(array($this,'helper'));
        spl_autoload_register(array($this,'controller'));
    }

    public function controller($class){
        
        $class = $this->trim_namespace($class);
        set_include_path($this->registry->appDir. '/controllers/');
        spl_autoload_extensions('.ctrl.php');
        spl_autoload($class);
    }

    public function model($class){
        
        $class = $this->trim_namespace($class);
        set_include_path($this->registry->appDir. '/models/');
        spl_autoload_extensions('.model.php');
        spl_autoload($class);
    }

    public function helper($class){
        
        $class = $this->trim_namespace($class);        
        set_include_path($this->registry->appDir. '/helpers/');
        spl_autoload_extensions('.help.php');
        spl_autoload($class);
    }
    
    private function trim_namespace($class){
        
        $class = explode('\\', $class);
        $class = array_pop($class);
        return $class;
    }
}
