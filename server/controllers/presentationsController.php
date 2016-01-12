<?php

namespace Controllers;

include_once ROOT . "/infrastructure/httpHandler.php";
use Infrastructure\httpHandler;

class presentationsController
{
    public function  get(){
        httpHandler::returnSuccess(array('P1', 'P2'));
    }
}