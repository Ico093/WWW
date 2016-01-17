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

        $response = array();

        if (isset($expires)) {
            $response['expires'] = $expires;
        }

        if (isset($errorMessage)) {
            $response['errorMessage'] = $errorMessage;
        }

        die(json_encode($response));
    }

    public static function returnSuccess($data)
    {
        $response = array('data'=>$data);

        if (isset(self::$expires)) {
            $response['expires'] = self::$expires;
        }

        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($response);
    }
}