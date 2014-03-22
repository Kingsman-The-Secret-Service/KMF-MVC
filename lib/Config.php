<?php

namespace KMF;

Class Config{

    protected $configData;
            
    function __construct($registry) {
        
        if(parse_ini_file($registry->configFile, TRUE)){
            
            $this->configData = parse_ini_file($registry->configFile, TRUE);
        
        }
        else{
            
            throw new Exception("Improper Config.ini File, Please Check it");
        }
        
    }
            
    function getAllConfig(){
        
        return $this->configData;
    }
    
    function getSitepath(){
                
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { 

        $http = 'https://';
        } else { 

        $http = 'http://';
        }
        
        if(isset($_SERVER['SERVER_PORT'])){
            
            $port = ':'.$_SERVER['SERVER_PORT'];
        }
        else{
            
            $port = '';
        }
       
        return $http.$_SERVER['SERVER_NAME'].$port.'/'.$this->configData['PATH']['APP'].'/';

    }
    
    function getAppNamespace(){
        
        return $this->configData['APPNAMESPACE'];
    }
            
    function getDbConfig(){
        
        return $this->configData['DB'];
    }
    
    function getAppPath(){
        
         if(isset($this->configData['PATH']['APP'])){
            
            $path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->configData['PATH']['APP'].'/';
        }
        else {
            
            throw new Exception("Please! Setup APP PATH in Your-App/config/config.ini File");
        }
        
        if(file_exists($path)){
            
            return $path;
        }
        
        echo $path;
       
    }
    
    function getKMFPath(){
       
        if(isset($this->configData['PATH']['KMF'])){
            
            $path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->configData['PATH']['KMF'].'/';
        }
        else {
            
            $path = __DIR__.'/KMF/';
        }
        
        if(file_exists($path)){
            
            return $path;
        }
        
        echo $path;
       throw new Exception("Please! Setup KMF Framework");
        
    }
    
    function getORMPath(){
       
        if(isset($this->configData['PATH']['ORM'])){
            
            $path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->configData['PATH']['ORM'].'/ActiveRecord.php';
        }
        else {
            
            throw new Exception("Please! Setup ORM PATH in Your-App/config/config.ini File");
        }
        
        if(file_exists($path)){
            
            return $path;
        }
        
       throw new Exception("Please! ORM DIR given in Config.ini file is incorrect (No Need of 'root' Dir)<br> e.g: Core/Library/ORM/");
        
    }
    
    
            
    function getTWIGPath(){
       
        if(isset($this->configData['PATH']['TWIG'])){
            
            $path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->configData['PATH']['TWIG'].'/Autoloader.php';
        }
        else {
            
            throw new Exception("Please! Setup TWIG DIR in Your-App/config/config.ini File");
        }
        
        if(file_exists($path)){
            
            return $path;
        }
        else{
            
            throw new Exception("Please! TWIG DIR given in Config.ini file is incorrect (No Need of 'root' Dir)<br> e.g: Core/Library/TWIG/");
        }
        
       
        throw new Exception;
    }
    
    function getDefaultController(){
        
        return $this->configData['DEFAULT']['CONTROLLER'];
    }
    
    function getDefaultDBConnection(){
        
        return $this->configData['DEFAULT']['DBCONNECTION'];
    }
    
    function getTemplate(){
        
        return $this->configData['DEFAULT']['TEMPLATE'];
    }
    
    function getMenuData(){
        
        return $this->configData['MENU'];
    }
}