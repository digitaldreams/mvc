<?php

require './config/Application.php';
spl_autoload_register(array('Application', 'autoload'));
try {
    $app = new Application();
    $app->run();
    
} catch (ErrorException $ex) {
    echo $ex->getMessage();
    
}