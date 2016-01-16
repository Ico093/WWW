<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/11/2016
 * Time: 18:57
 */

namespace Infrastructure;


class httpHandler
{
    public static $expires;

    public static function returnError($errorNo, $errorMessage = '')
    {
        http_response_code($errorNo);
        header('Content-Type: application/json; charset=UTF-8');

        $responce = array();

        if (isset($expires)) {
            $responce['expires'] = $expires;
        }

        if (isset($errorMessage)) {
            $responce['errorMessage'] = $errorMessage;
        }

        die(json_encode($responce));
    }

    public static function returnSuccess($data)
    {
        $responce = array('data'=>$data);

        if (isset(self::$expires)) {
            $responce['expires'] = self::$expires;
        }

        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($responce);
    }
}