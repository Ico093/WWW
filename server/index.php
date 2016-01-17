<?php
//// Define root dir and root path
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DX_DS', '/');
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']);


include_once 'infrastructure/authentication.php';
include_once 'infrastructure/httpHandler.php';

use Infrastructure\httpHandler;
use Infrastructure\authentication;

cors();

$virtualPath = ROOT_URL . DX_DS;
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$request_home = '/';
$request = substr($currentURL, strlen($virtualPath));
$separator = '/';

$components = array();
$api = '';
$controller = '';
$method = '';
$param = array();


// Parse URL
$components = explode('/', $request);

if (count($components) > 2) {
    list($api, $controller, $method) = $components;

    $controller = $controller . 'Controller';

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($components[3])){
            $components = explode('?', $components[3]);
            $param = $components[0];
        }else{
            $components = explode('?', $method);
            $method = $components[0];
            $param = isset($components[1]) ? $components[1] : array();
        }
    }else{
        $param = isset($components[3]) ? $components[3] : array();
    }
}

// If the controller is found
if (!isset($api) || $api !== 'api') {
    httpHandler::returnError(400, "Incorrect path.");
}

if (isset($controller) && file_exists('controllers/' . $controller . '.php')) {
    if(strcmp($method,'login')!=0 && strcmp($method,'register')!=0){
        $authentication = new authentication();

        $token='';

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])){
            $token=$_POST['token'];
        }else if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['token'])){
            $token=$_GET['token'];
        }

        if($authentication->isUserLoggedIn($token)){
            $authentication->updateExpiryToken($token);
            httpHandler::$userId = $authentication->getLoggedUserId($token);
            httpHandler::$username = $authentication->getLoggedUser($token);
        }else{
            httpHandler::returnError(401, "Unauthorized");
        }
    }

    include_once 'controllers/' . $controller . '.php';

    $controller_class = 'Controllers\\' . $controller;

    $instance = new $controller_class();

    // Call the object and the method
    if (method_exists($instance, $method)) {
        call_user_func_array(array($instance, $method), array($param));
    } else {
        // fallback to index
        echo $method;
    }
} else {
    echo 'No Such Controller';
}

function cors() {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}