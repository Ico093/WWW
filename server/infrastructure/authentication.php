<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:06
 */

namespace Infrastructure;

use DataRepositories\accountsRepository;

include_once ROOT . '/data/repositories/accountsRepository';
include_once ROOT . '/infrastructure/httpHandler.php';

class authentication
{
    private $accountsRepository;

    public function __construct()
    {
        $this->accountsRepository = new accountsRepository();
    }

    public function login($userId)
    {
        $token = $this->generateGUID();

        $this->accountsRepository->login($userId, $token);

        return $token;
    }

    public function isUserLoggedIn($token)
    {
        return $this->accountsRepository->hasToken($token);
    }

    public function getLoggedUser($token)
    {
        return $this->accountsRepository->getUserId($token);
    }

    public function generateGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4)
                . chr(125);// "}"
            return $uuid;
        }
    }
}