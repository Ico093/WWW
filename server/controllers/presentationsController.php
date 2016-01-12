<?php

namespace Controllers;

include_once ROOT . "/infrastructure/httpHandler.php";
include_once ROOT . "/data/repositories/presentationsRepository.php";

use Infrastructure\httpHandler;
use DataRepositories\presentationsRepository;

class presentationsController
{
    private $presentationsRepository;

    public function __construct()
    {
        $this->presentationsRepository = new presentationsRepository();
    }

    public function  get(){
        $presentations = $this->presentationsRepository->getPresentations();
        httpHandler::returnSuccess($presentations);
    }
}