<?php

namespace Controllers;

include_once ROOT . "/infrastructure/httpHandler.php";
include_once ROOT . "/data/repositories/feedbacksRepository.php";

use Infrastructure\httpHandler;
use DataRepositories\feedbacksRepository;

class feedbacksController
{
    private $feedbacksRepository;

    public function __construct()
    {
        $this->feedbacksRepository = new feedbacksRepository();
    }

    public function submit(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = $_POST["content"];
            $presentationId = $_POST["presentationId"];
            $userId = httpHandler::$userId;

            if($this->feedbacksRepository->submitFeedback($presentationId, $userId, $content) === true){
                httpHandler::returnSuccess(200, "Коментарът е добавен.");
            }
            else{
                httpHandler::returnError(500, "Коментарът не може да бъде записан.");
            }
        }
        else {
            httpHandler::returnError(405);
        }
    }
}