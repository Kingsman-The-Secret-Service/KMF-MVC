<?php

namespace KMF;

Class Model{
    
    private $registry;
    protected $connections;
    protected $defaultConnection;
            
    function __construct($registry) {
       
        $this->registry = $registry;

        $config = new Config($this->registry);
        $this->defaultConnection = $config->getDefaultDBConnection();
        $dbData = $config->getDBConfig();
        
        foreach ($dbData as $key => $value){

             $connections[$key] = "mysql://".$value['USER'].":".$value['PASS']."@".$value['HOST'].(isset($value['PORT']) ? ":".$value['PORT'] : NULL)."/".$value['NAME'];
        }

        $this->connections = $connections;

        require $config->getORMPath();
        $this->invokeModel();
    }
    
     
    private function invokeModel(){
        
        $cfg = \ActiveRecord\Config::instance();
        $cfg->set_model_directory($this->registry->appDir.'/models/');
        $cfg->set_connections($this->connections);
        $cfg->set_default_connection($this->defaultConnection);
    }
    
    
}
