<?php
include_once 'infrastructure/httpHandler.php';

use Infrastructure\httpHandler;

//// Define root dir and root path
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

define('DX_DS', '/');
define('DX_ROOT_DIR', dirname(__FILE__));
define('DX_ROOT_PATH', basename(dirname(__FILE__)) . DX_DS);
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']);

header("Access-Control-Allow-Origin: *");
session_start();

//// Bootstrap
////include 'config/bootstrap.php';
//// Define the request home that will always persist in REQUEST_URI
//$mysqli = new mysqli( '6d111ce2-082e-4933-a8f0-a589012ab50d.mysql.sequelizer.com', 'jaczbgiemgrsfjky', '5uJxTSFWdq44eVdQdrA4hbrALwWf6ouwtqHfAdBLCsZUszgRk8Q43CY4diTv5AZX', 'db6d111ce2082e4933a8f0a589012ab50d' );
//$mysqli = new mysqli( 'localhost', 'root', 'root', 'presento' );
//if($mysqli->connect_error)
//{
//    die("$mysqli->connect_errno: $mysqli->connect_error");
//}
//
//$stmt = $mysqli->stmt_init();
//$stmt->prepare('select * from users');
//$stmt->execute();
//$result = $stmt->get_result();
//while ($row = $result->fetch_array(MYSQLI_NUM))
//{
//    foreach ($row as $r)
//    {
//        print "$r ";
//    }
//    print "\n";
//}
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

$admin_routing = false;
$admin_folder = '';
$admin_namespace = '';

include_once 'infrastructure/authentication.php';

// Switch to admin routing
//    if (0 === strpos($request, 'admin')) {
//        $admin_routing = true;
//        include_once 'controllers/admin/admin_controller.php';
//        $request = substr($request, strlen('admin/'));
//    }

// Parse URL
$components = explode('/', $request);

if (count($components) > 2) {
    list($api, $controller, $method) = $components;
    $controller = $controller . 'Controller';
    $param = isset($components[3]) ? $components[3] : array();
}

// If the controller is found
if (!isset($api) || $api !== 'api') {
    httpHandler::returnError(400, "Incorrect path.");
}

if (isset($controller) && file_exists('controllers/' . $controller . '.php')) {
//    if ($admin_routing) {
//        $admin_folder = $admin_routing ? 'admin/' : '';
//        $admin_namespace = $admin_routing ? 'Admin' : '';
//    }

    include_once 'controllers/' . $admin_folder . $controller . '.php';

    $controller_class = $admin_namespace . 'Controllers\\' . $controller;

    $instance = new $controller_class();

    // Call the object and the method
    if (method_exists($instance, $method)) {
        call_user_func_array(array($instance, $method), array($param));
    } else {
        // fallback to index
        echo 'No Such Method';
    }
} else {
    echo 'No Such Controller';
}