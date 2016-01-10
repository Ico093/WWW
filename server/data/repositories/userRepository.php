<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:42
 */

namespace DataRepositories;

include_once 'BaseRepositories/baseRepository.php';

class userRepository extends baseRepository
{
    function registerUser($id, $username, $password)
    {
        if(!doesUserExist($username)){
            $sql = "INSERT INTO users (Id, Username, Password) VALUES (?,?,?)";
            $statement = $this->prepareSQL($sql);
            $statement->bind_param('sss', $id, $username, $password);

            if($statement->execute()===TRUE){
                return true;
            }
            else{
                throw new Exception('Division by zero.');
            }
        }

        throw new Exception('User exists.');
    }

    function doesUserExist($username){
        $sql = "SELECT COUNT(username) FROM users WHERE username = ?";

        $statement = $this->prepareSQL($sql);
        $statement->bind_param('s', $username);

        $result_set = $statement->get_result();

        if ( $row = $result_set->fetch_assoc() ) {
            return true;
        }

        return false;
    }

}