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
    public static function returnError($errorNo, $errorMessage=''){
        http_response_code($errorNo);
        header('Content-Type: application/json; charset=UTF-8');

        if(isset($errorMessage)){
            die(json_encode(array('data' => $errorMessage)));
        }

        die();
    }

    public static function returnSuccess($data){
        http_response_code(200);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data);
    }
}