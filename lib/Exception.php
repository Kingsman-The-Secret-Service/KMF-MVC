<?php

namespace KMF{
    
    class Exception extends \Exception{
        
        function __construct($message) {
            
            echo '<pre style="color:red; padding:100px;">';
            echo '<h1>KMF Error:</h1>';
            echo '<h3>'.$message.'</h3>';
            echo '</pre>';
            die();
        }
    }
}

