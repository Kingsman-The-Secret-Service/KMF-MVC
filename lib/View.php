<?php

namespace KMF;

Class View {

    private $registry;
    private $data = array();

    function __construct($registry) {
        $this->registry = $registry;
    }

    function __set($varName, $varValue) {
        $this->data[$varName] = $varValue;
    }

    function __get($varName) {
        return $this->data[$varName];
    }

    function render(){
        
       echo $this->template()->render($this->data);
    }

    function display(){

        echo $this->template()->display($this->data);
    }

    private function template(){

        $config = new Config($this->registry);

        $twigPath = $config->getTWIGPath();

        $this->themeUrl = $this->registry->siteUrl .'themes/'. $this->registry->template .'/';
        $this->isAjaxRequest = $this->registry->dispatcher->isAjaxRequest();
        
        require $twigPath;
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem($this->getTemplate());
        $twig = new \Twig_Environment($loader);
        
        $urlFunction = new \Twig_SimpleFunction('url', function ($ctrl_action, $paramsArray = NULL) {
            
            $ctrl_action = explode('/', $ctrl_action);
            $controller = $ctrl_action[0].'/';
            $action = $ctrl_action[1].'/';
            
            $params = '';
            if(isset($paramsArray)){

                $params .= '?';
                foreach ($paramsArray as $key => $value){

                    $params .= $key.'='.$value;

                    if(end($paramsArray) != $value){

                        $params .= '&';
                    }
                }
            }
        
            $url =  $this->registry->siteUrl.$controller.$action.$params;        
            return $url;
        });
        
        $twig->addFunction($urlFunction);
        
        $template = $twig->loadTemplate($this->getView());

        return $template;
    }
    
    private function getView($controller = NULL, $action = NULL){

        $controller = empty($controller) ? $this->registry->dispatcher->getController(): $controller;
        $action = empty($action) ? $this->registry->dispatcher->getAction() : $action;

        $viewFile = 'views/'.$controller.'/'.$action.'.html';

        if(is_readable($this->getTemplate().$viewFile) == FALSE && file_exists($this->getTemplate().$viewFile) == FALSE){

            throw new Exception('Invalid VFile: '.$viewFile);
        }

        return $viewFile;
    }
    
    
    private function getTemplate(){
        
        $templateDir = $this->registry->appDir.'themes/'.$this->registry->template.'/';
        
        if(is_readable($templateDir) == FALSE && file_exists($templateDir) == FALSE){

            throw new Exception('Invalid TFile: '.$templateDir);
        }
        
        return $templateDir;
    }
}
