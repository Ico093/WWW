<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:06
 */

namespace Infrastructure;

include_once 'httpHandler.php';

class authentication
{
    private $now;

    public function __construct()
    {
        $this->now = time();
    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['token']);
    }

    public function hasSession(){
        if (isset($_SESSION['discard_after'])){
            if($this->now > $_SESSION['discard_after']) {
                $this->logout();
                httpHandler::returnError(401, "No information about you on the server.");
            }else{
                $_SESSION['discard_after'] = $this->now + 1;
                return true;
            }
        }

        return false;
    }

    public function login($id, $username)
    {
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['token']=$this->generateGUID();
        $_SESSION['discard_after'] = $this->now + 3600;

        return $_SESSION['token'];
    }

    public function logout()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
    }

    public function get_logged_user()
    {
        if (!isset($_SESSION['username'])) {
            return array();
        }

        return array(
            'username' => $_SESSION['username'],
            'user_id' => $_SESSION['user_id']
        );

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