<?php
// Define root dir and root path
define('DX_DS', DIRECTORY_SEPARATOR);
define('DX_ROOT_DIR', dirname(__FILE__) . DX_DS);
define('DX_ROOT_PATH', basename(dirname(__FILE__)) . DX_DS);
define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST']);
// Bootstrap
//include 'config/bootstrap.php';
// Define the request home that will always persist in REQUEST_URI

$request_home = '/';
// Read the request
$request = $_SERVER['REQUEST_URI'];
$separator = '/';

$components = array();
$api = '';
$controller = 'Master';
$method = 'index';
$param = array();

$admin_routing = false;
$admin_folder='';
$admin_namespace='';
//include_once 'lib/database.php';
include_once 'infrastructure/authentication.php';

    echo \Infrastructure\Authentication::generateGUID();
if (!empty($request)) {
    // Switch to admin routing
    if (0 === strpos($request, 'admin')) {
        $admin_routing = true;
//        include_once 'controllers/admin/admin_controller.php';
        $request = substr($request, strlen('admin/'));
    }

    // Fetch the controller, method and params if any
    $components = explode('/', $request);

    $api = isset($components[1]) ? $components[1] : $api = '';

    if ($api === 'api') {
        $controller = isset($components[2]) ? $components[2] . 'Controller' : $controller = '';
        $method = isset($components[3]) ? $components[3] : $method = '';
        $param = isset($components[4]) ? $components[4] : array();
    }
}
// If the controller is found
if (isset($controller) && file_exists('controllers/' . $controller . '.php')) {
    if ($admin_routing) {
        $admin_folder = $admin_routing ? 'admin/' : '';
        $admin_namespace = $admin_routing ? 'Admin' : '';
    }

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