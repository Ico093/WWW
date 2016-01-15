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

    public function getById($id){
        $presentation = $this->presentationsRepository->getPresentationById($id);
        httpHandler::returnSuccess($presentation);
    }

    public function create(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST["title"];
            $description = $_POST["description"];
            $date = $_POST["date"];
            $from = $_POST["from"];
            $to = $_POST["to"];
            $username = $_POST["username"];

            $presentation = array();
            array_push($presentation,
                array(
                    'title' => $title,
                    'description' => $description,
                    'date' => $date,
                    'from' => $from,
                    'to' => $to,
                    'username' => $username));

            if ($this->presentationsRepository->createPresentation($presentation)) {
                httpHandler::returnSuccess(200, "Презентацията е добавена.");
            } else {
                httpHandler::returnError(500, 'Настъпи грешка!');
            }
        }
    }
}