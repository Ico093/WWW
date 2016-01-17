<?php

namespace Controllers;

include_once ROOT . "/infrastructure/httpHandler.php";
include_once ROOT . "/data/repositories/presentationsRepository.php";
include_once ROOT . "/data/repositories/feedbacksRepository.php";

use DataRepositories\feedbacksRepository;
use Infrastructure\httpHandler;
use DataRepositories\presentationsRepository;

class presentationsController
{
    private $presentationsRepository;
    private $feedbacksRepository;

    public function __construct()
    {
        $this->presentationsRepository = new presentationsRepository();
        $this->feedbacksRepository = new feedbacksRepository();
    }

    public function get()
    {
        $presentations = $this->presentationsRepository->getPresentations();
        httpHandler::returnSuccess($presentations);
    }

    public function getById($id)
    {
        $presentation = $this->presentationsRepository->getPresentationById($id);
        $feedbacks = $this->feedbacksRepository->getFeedbacksByPresentationId($id);
        $presentation['feedbacks'] = $feedbacks;
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
            $userId = httpHandler::$userId;

            $presentation = array(
                'title' => $title,
                'description' => $description,
                'ondate' => $ondate,
                'fromtime' => $fromtime,
                'totime' => $totime,
                'userId' => $userId);

            if ($this->presentationsRepository->createPresentation($presentation)) {
                httpHandler::returnSuccess(200, "Презентацията е добавена.");
            } else {
                httpHandler::returnError(500, 'Настъпи грешка. Презентацията не може да бъде добавена.');
            }

            if (!empty($_FILES) && isset($_FILES["presentationFile"])) {
                $file = $_FILES["presentationFile"];
                $errors = $this->uploadFile($title, $file);
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

                $errors = $this->uploadFile($title, $file);
                if (count($errors) > 0) {
                    httpHandler::returnError(500, 'Настъпи грешка със записването на файла.');
                }
            }
        }
    }

    public function delete($id)
    {
        $isPresentationDeleted = $this->presentationsRepository->deletePresentation($id);
        if ($isPresentationDeleted === true) {
            httpHandler::returnSuccess(200, "Презентацията е изтрита успешно.");
        } else {
            httpHandler::returnError(500, 'Настъпи грешка при изтриването на презентацията.');
        }
    }

    public function downloadFile($id)
    {
        $presentation = $this->presentationsRepository->getPresentationName($id);

        $uploaddir = '../uploads/presentations/' . "ico" . '/';
        $fileExt = '';
        if (file_exists($uploaddir . $presentation . '.' . 'ppt'))
            $fileExt = 'ppt';
        if (file_exists($uploaddir . $presentation . '.' . 'pptx'))
            $fileExt = 'pptx';

        if (strcmp($fileExt, "") === 0) { // file does not exist
            httpHandler::returnError(404, "No such file in the system.");
        } else {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$presentation.$fileExt");
            header("Content-Type: application/$fileExt");

            // read the file from disk
            readfile($uploaddir . $presentation . '.' . $fileExt);
        }
    }

    private function uploadFile($presentation, $file)
    {
        $errors = array();
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $extensions = array("ppt", "pptx");
        if (in_array($file_ext, $extensions) === false) {
            array_push($errors, "Невалиден формат за презентация.");
        }
        if (empty($errors) == true) {
            $uploaddir = '../uploads/presentations/' . httpHandler::$username . '/';

            if (!file_exists($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }

            if (file_exists($uploaddir . $presentation . '.' . 'ppt'))
                unlink($uploaddir . $presentation . '.' . 'ppt');
            if (file_exists($uploaddir . $presentation . '.' . 'pptx'))
                unlink($uploaddir . $presentation . '.' . 'pptx');

            if (move_uploaded_file($file_tmp, $uploaddir . $presentation . '.' . $file_ext) === false) {
                array_push($errors, "Файлът на презентацията не може да бъде качен на сървъра.");
            }
        }

        return $errors;
    }
}