<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/10/2016
 * Time: 12:22
 */

namespace Controllers;

include_once ROOT . "/data/repositories/accountsRepository.php";
include_once ROOT . "/infrastructure/httpHandler.php";
include_once ROOT . "/infrastructure/authentication.php";

use DataRepositories\accountsRepository;
use Infrastructure\httpHandler;
use Infrastructure\authentication;

class accountsController
{
    private $accountsRepository;
    private $authentication;

    public function __construct()
    {
        $this->accountsRepository = new accountsRepository();
        $this->authentication = new authentication();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $username = $request->username;
            $password = $request->password;

            if (isset($username) && isset($password)) {
                try {
                    $this->accountsRepository->registerUser($username, $password);

                    httpHandler::returnSuccess(array('message'=>'Успешно регистриране'));
                } catch (\Exception $ex) {
                    if ($ex->getCode() === 1062)//Username exists
                    {
                        httpHandler::returnError(400, "Съществува такъв потребител");
                    } else {
                        httpHandler::returnError(500);
                    }
                }
            } else {
                httpHandler::returnError(400, 'Грешни параметри');
            }
        } else {
            httpHandler::returnError(405);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $username = $request->username;
            $password = $request->password;

            if (isset($username) && isset($password)) {
                $id = $this->accountsRepository->hasUser($username, $password);

                if ($id !== NULL) {
                    $result = $this->authentication->login($id);
                    $result['message']='Успешно логване';

                    httpHandler::returnSuccess($result);
                } else {
                    httpHandler::returnError(401, 'Няма такъв потребител');
                }
            } else {
                httpHandler::returnError(400, 'Грешни параметри');
            }
        } else {
            httpHandler::returnError(405, 'Грешен метод');
        }
    }

    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["token"])) {
                $token = $_POST["token"];

                $this->accountsRepository->removeLogin($token);
            }
        }
    }
}