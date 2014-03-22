<?php

namespace KMF;

Abstract Class Controller{

    protected $registry;
    protected $view;
    protected $dispatcher;
    protected $menu;

    abstract function index();
    
    function __construct($registry) {
        
        $this->registry = $registry;
        $this->dispatcher = $registry->dispatcher;
        $this->view = $registry->view;
        $this->menu = $registry->menu;
        new Model($this->registry);
        
        $this->menu();
    }
    
    
    function url($attributes){

        if(is_array($attributes)){

            if(isset($attributes['controller'])){

                $controller = $attributes['controller'].'/';
            }

            if(isset($attributes['action'])){

                $action = $attributes['action'].'/';
            }
            else{
                
                $action = '';
            }

            $params = '';
            if(isset($attributes['params'])){

                $params .= '?';
                foreach ($attributes['params'] as $key => $value){

                    $params .= $key.'='.$value;

                    if(end($attributes['params']) != $value){

                        $params .= '&';
                    }
                }
            }
        }
        
        $url =  $this->registry->siteUrl.$controller.$action.$params;        
        return $url;
    }
       
    function redirect($attributes){
        
        $url = $this->url($attributes);
        header('Location:'.$url);
    }
    
    function menu(){

        foreach ($this->menu as $controller => $value){
            
            foreach ($value as $action => $val){
                    
                $menu[$controller][$val] = $this->url(array('controller'=> $controller, 'action' => $action));
            }
        }
        
        return $menu;
    }

}