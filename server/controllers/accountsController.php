<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/10/2016
 * Time: 12:22
 */

namespace Controllers;

use DataRepositories\accountsRepository;
use DataRepositories\baseRepository;

class accountController extends baseRepository
{
    private $accountsRepository;

    function __construct()
    {
        $accountsRepository = new accountsRepository();
    }

    public function login($username, $password){
        try{
            $this->accountsRepository->login($username,$password);
        }
        catch(Exception $ex){

        }
    }
}