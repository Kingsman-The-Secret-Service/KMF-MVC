<?php

namespace KMF;

Class Dispatcher{

    private $registry;
    private $controller;
    private $action;
    private $params;

    function __construct($registry) {
        
        $this->registry = $registry;
        $this->setController();
        $this->setAction();
        $this->setParams();
    }

    public function load(){

        $this->invokeAction();
    }

    private function setController(){
        
        $controllerDir = $this->registry->appDir.'controller';

        if(is_dir($controllerDir) == FALSE){

            throw new Exception('Invalid CDirectory: '.$controllerDir);
        }
        
        $controller = (empty($_GET['controller'])? strtolower($this->registry->defaultController) : strtolower($_GET['controller']));
        
        $controllerFile = $controllerDir.'/'.$controller.'.ctrl.php';

        if(is_readable($controllerFile) == FALSE && file_exists($controllerFile) == FALSE){

            throw new Exception('Invalid CFile: '.$controllerFile);
        }

        $this->controllerFile = $controllerFile;
        $this->controller = $controller;
    }

    public function getController(){
        
        return $this->controller;
    }

    private function invokeController() {

        include $this->controllerFile;
        
        if(class_exists($this->registry->appNamespace.'\\'.$this->controller)){

            $class = $this->registry->appNamespace.'\\'.$this->controller;
            $controllerObj = new $class($this->registry);
            return $controllerObj;
        }
        else{

            throw new Exception('Class does,\'t exists');
        }
    }

    private function setAction(){

        $this->action = (empty($_GET['action'])? 'index': $_GET['action']);
    }

    public function getAction(){

       return $this->action;
    }

    private function invokeAction(){

        $controllerObj = $this->invokeController();
        $method = $this->action;

        if(method_exists($controllerObj, $method) && (is_callable(array($controllerObj, $method)))){

            $controllerObj->$method();
        }
        else {

            throw new Exception('Method does,\'t exists');
        }
    }

    private function setParams(){
        $get = $_GET;
        unset($get['controller']);
        unset($get['action']);

        if(empty($get) == FALSE && isset($get) == TRUE){

            foreach ($get as $key => $value){

                $params[$key] = $value;
            }

            $this->params = $params;
        }
        else {

            $this->params = array();
        }
    }

    public function getParams(){

        return $this->params;
    }
    
    public function isAjaxRequest(){
        
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'){
            
            return TRUE;
        }
        return FALSE;
    }
}