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

    public function get()
    {
        $presentations = $this->presentationsRepository->getPresentations();
        httpHandler::returnSuccess($presentations);
    }

    public function getById($id)
    {
        $presentation = $this->presentationsRepository->getPresentationById($id);
        httpHandler::returnSuccess($presentation);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST["title"];
            $description = $_POST["description"];
            $ondate = $_POST["ondate"];
            $fromtime = $_POST["fromtime"];
            $totime = $_POST["totime"];
            $username = "izi";
            /*$username = $_POST["username"];*/

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
                httpHandler::returnError(500, 'Настъпи грешка. Презентацията не може да бъде добавена.');
            }

            if (!empty($_FILES) && isset($_FILES["presentationFile"])) {
                $file = $_FILES["presentationFile"];
                $errors = $this->uploadFile($file);
                if (count($errors) > 0) {
                    httpHandler::returnError(500, 'Настъпи грешка със записването на файла.');
                }
            }
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST["title"];
            $description = $_POST["description"];
            $ondate = $_POST["ondate"];
            $fromtime = $_POST["fromtime"];
            $totime = $_POST["totime"];

            $presentation = array(
                'title' => $title,
                'description' => $description,
                'ondate' => $ondate,
                'fromtime' => $fromtime,
                'totime' => $totime);

            if ($this->presentationsRepository->updatePresentation($id, $presentation)) {
                httpHandler::returnSuccess(200, "Презентацията е обновена.");
            } else {
                httpHandler::returnError(500, 'Настъпи грешка. Презентацията не може да бъде обновена.');
            }

            if (!empty($_FILES) && isset($_FILES["presentationFile"])) {

                $file = $_FILES["presentationFile"];

                $errors = $this->uploadFile($file, true);
                if (count($errors) > 0) {
                    httpHandler::returnError(500, 'Настъпи грешка със записването на файла.');
                }
            }
        }
    }

    public function  delete($id){
        $isPresentationDeleted = $this->presentationsRepository->deletePresentation($id);
        if($isPresentationDeleted === true){
            httpHandler::returnSuccess(200, "Презентацията е изтрита успешно.");
        }
        else{
            httpHandler::returnError(500, 'Настъпи грешка при изтриването на презентацията.');
        }
    }

    private function uploadFile($file, $shouldClearDirectory = false){
        $errors= array();
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $extensions = array("ppt", "pptx");
        if (in_array($file_ext, $extensions) === false) {
            array_push($errors, "Невалиден формат за презентация.");
        }
        if (empty($errors) == true) {
            /*$uploaddir = './uploads/file/'.$current_user->user_login.'/';*/
            $uploaddir = '../uploads/presentations/';
            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            if ($shouldClearDirectory === true) {

                /* TODO: Make directory path uploads/presentations/currentuser_username/presentation_title
                       Clear directory before uploading the new presentation in case of updating ($shouldClearDirectory === true);*/
            }

            if (move_uploaded_file($file_tmp, $uploaddir . $file_name) === false) {
                array_push($errors, "Файлът на презентацията не може да бъде качен на сървъра.");
            }
        }

        return $errors;
    }
}