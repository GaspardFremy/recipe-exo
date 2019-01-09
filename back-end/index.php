<?php
require_once 'vendor/autoload.php';
include_once 'app/config/Database.php';
include_once 'app/models/Recipe.php';

$klein = new \Klein\Klein();

$base  = dirname($_SERVER['PHP_SELF']);

// Update request when we have a subdirectory
if(ltrim($base, '/')){
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
}

//error handler
$klein->onError(function ($klein, $message) {
    $msg = array(
        'message' => $message
    );
    echo json_encode($msg);
});

foreach(array('recipe') as $controller) {
    //redirect do dedicate controllers
    $klein->with("/$controller", "app/controllers/". ucfirst($controller) . "Controller.php");
}

$klein->dispatch();
