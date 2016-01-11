<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:42
 */

namespace DataRepositories;

include_once 'BaseRepositories/baseRepository.php';

class accountsRepository extends baseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
        $sql = "SELECT Id FROM users WHERE Username=? AND Password=?";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('ss', $username, $password);
        $statement->execute();

        $result = $statement->get_result()->fetch_row();
        return $result[0];//Id
    }

    public function registerUser($username, $password)
    {
        $sql = "INSERT INTO users (Username, Password) VALUES (?,?)";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('ss', $username, $password);

        if ($statement->execute() === FALSE) {
            throw new \Exception($this->dbConnection->error, $this->dbConnection->errno);
        }
    }
}