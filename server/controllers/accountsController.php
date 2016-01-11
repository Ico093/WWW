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

    public function login()
    {
        if ($_POST) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                $id = $this->accountsRepository->login($username, $password);

                if($id!==NULL){
                    $token = $this->authentication->login($id, $username);
                    httpHandler::returnSuccess(array('token'=>$token));
                }else{
                    httpHandler::returnError(401, 'No such user.');
                }
            }
            else{
                httpHandler::returnError(400, 'Wrong paramethers.');
            }
        }
        else{
            httpHandler::returnError(405);
        }
    }

    public function register()
    {
        if ($_POST) {
            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                try {
                    $isLoggedIn = $this->accountsRepository->registerUser($username, $password);
                } catch (\Exception $ex) {
                    if($ex->getCode() === 1062 )//Username exists
                    {
                        httpHandler::returnError(400,"User with this username already exists.");
                    }else{
                        httpHandler::returnError(500);
                    }
                }
            }
            else{
                httpHandler::returnError(400, 'Wrong paramethers.');
            }
        }
        else{
            httpHandler::returnError(405);
        }
    }
}