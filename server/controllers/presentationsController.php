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

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST["title"];
            $description = $_POST["description"];
            $ondate = $_POST["ondate"];
            $fromtime = $_POST["fromtime"];
            $totime = $_POST["totime"];
            $username = "izi";
            /*$username = $_POST["username"];*/
            /*$file = $_FILES["presentationFile"];*/

            $presentation = array(
                'title' => $title,
                'description' => $description,
                'ondate' => $ondate,
                'fromtime' => $fromtime,
                'totime' => $totime,
                'username' => $username);

            if ($this->presentationsRepository->createPresentation($presentation)) {
                httpHandler::returnSuccess(200, "Презентацията е добавена.");
            } else {
                httpHandler::returnError(500, 'Настъпи грешка.');
            }
        }
    }
}