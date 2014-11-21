<?php
require './config/Application.php';
spl_autoload_register(array('Application','autoload'));
$app=new Application();
$app->run();