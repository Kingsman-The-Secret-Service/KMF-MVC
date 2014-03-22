<?php

namespace KMF;

if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('KMF Framework requires PHP 5.3 or higher');

require __DIR__.'/lib/Controller.php';
require __DIR__.'/lib/Dispatcher.php';
require __DIR__.'/lib/Exception.php';
require __DIR__.'/lib/Model.php';
require __DIR__.'/lib/Registry.php';
require __DIR__.'/lib/View.php';
require __DIR__.'/lib/Autoloader.php';
require __DIR__.'/lib/Config.php';

Class Bootstrap{
    
    function __construct($config) {

        $registry = new registry;
        new Autoloader($registry);
        
        $registry->configFile = $this->getConfig($config);
        $configData = new Config($registry);
        $registry->siteUrl = $configData->getSitepath();
        $registry->appDir = $configData->getAppPath();
        $registry->appNamespace = $configData->getAppNamespace();
        $registry->menu = $configData->getMenuData();
        $registry->defaultController = $configData->getDefaultController();
        $registry->template = $configData->getTemplate();
        $registry->dispatcher = new Dispatcher($registry);
        $registry->view = new View($registry);
        $registry->dispatcher->load();
    }
    
    function getConfig($config){
        
        if(file_exists($config)){
            
            return $config;
        }
        
        throw new Exception("Please! Setup Config.ini File");
    }
}
