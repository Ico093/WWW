<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:06
 */

namespace Infrastructure;


class Authentication
{
    private static $session = null;

    private function __construct() {
        session_start();

        $now = time();
        if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
            // this session has worn out its welcome; kill it and start a brand new one
            session_unset();
            session_destroy();
            return;
        }

        $_SESSION['discard_after'] = $now + 3600;
    }

    public static function get_instance() {
        static $instance = null;

        if ( null === $instance ) {
            $instance = new static();
        }

        return $instance;
    }

    public function is_logged_in() {
        if ( isset( $_SESSION['username'] ) ) {
            return true;
        }
        return false;
    }

    public function login( $username, $password ) {
//        $db = \Lib\Database::get_instance();
//        $dbconn = $db->get_db();
//
//
//        $statement = $dbconn->;
//        $statement->bind_param( 'ss', $username, $password );
//
//        $statement->execute();
//
//        $result_set = $statement->get_result();
//
//        if ( $row = $result_set->fetch_assoc() ) {
//            $_SESSION['username'] = $username;
//            $_SESSION['user_id'] = $row['id'];
//
//            return true;
//        }
//
//        return false;
    }

    public function logout( ) {
        session_destroy();
    }

    public function get_logged_user() {
        if ( ! isset( $_SESSION['username'] )  ) {
            return array();
        }

        return array(
            'username' => $_SESSION['username'],
            'user_id' => $_SESSION['user_id']
        );

    }

    function generateGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .chr(125);// "}"
            return $uuid;
        }
    }
}