<?php
namespace Controllers;
class MasterController
{
    protected $model = null;

    protected $class_name = null;

    protected $logged_user = array();

    private $conn;

    public function __construct($class_name = 'MasterController', $model = 'master')
    {
        // Get caller classes
        $this->class_name = $class_name;

        $this->model = $model;
        session_start();
        $servername = "localhost";
        $username = "root";
        $password = "";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password);

// 		$this_class = get_class();
// 		$called_class = get_called_class();

// 		if( $this_class !== $called_class ) {
// 			var_dump( $called_class );
// 		}

//        include_once DX_ROOT_DIR . "models/{$model}.php";
//        $model_class = "\models\\" . ucfirst( $model ) . "_Model";

//        $this->model = new $model_class( array( 'table' => 'none' ) );

//        $logged_user = \Lib\Auth::get_instance()->get_logged_user();
//        $this->logged_user = $logged_user;
    }

    public function home()
    {
        $_SESSION["favcolor"] = "green";
    }

    public function index()
    {
        echo $_SESSION["favcolor"];
    }

}