<?php
namespace Controllers;

include_once ROOT . "/infrastructure/authentication.php";

use Infrastructure\authentication;

class MasterController
{
    public function home()
    {
        if((new authentication())->hasSession()){
            echo 1;

        }else{
            echo 2;
        }
//        echo $_SESSION['token'];
    }

    public function index()
    {
        echo 'index';
    }

}