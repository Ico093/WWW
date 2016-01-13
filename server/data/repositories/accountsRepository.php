<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:42
 */

namespace DataRepositories;

include_once ROOT . '\data\repositories\BaseRepositories\baseRepository.php';

class accountsRepository extends baseRepository
{
    public function __construct()
    {
        parent::__construct();
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

    public function hasUser($username, $password)
    {
        $sql = "SELECT Id FROM users WHERE Username=? AND Password=?";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('ss', $username, $password);

        if ($statement->execute() === FALSE) {
            throw new \Exception($this->dbConnection->error, $this->dbConnection->errno);
        }

        $result = $statement->get_result()->fetch_row();
        return $result[0];//Id
    }

    public function login($userId, $token)
    {
        $sql = "INSERT INTO logins (UserId, Token, Expiration) VALUES(?,?,?)";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('sss', $userId, $token, date('Y-m-d H:i:s'));
        $statement->execute();

        if ($statement->execute() === FALSE) {
            throw new \Exception($this->dbConnection->error, $this->dbConnection->errno);
        }
    }

    public function removeLogin($token)
    {
        $sql = "DELETE FROM logins WHERE Token=?";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('s', $token);
        $statement->execute();

        if ($statement->execute() === FALSE) {
            throw new \Exception($this->dbConnection->error, $this->dbConnection->errno);
        }
    }

    public function hasToken($token)
    {
        $sql = "SELECT Id FROM logins WHERE Token=?";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('s', $token);

        if ($statement->execute() === FALSE) {
            throw new \Exception($this->dbConnection->error, $this->dbConnection->errno);
        }

        return $statement->get_result()->fetch_row()[0] === NULL ? false : true;
    }

    public function getUserId($token)
    {
        $sql = "SELECT UserId FROM logins WHERE Token=?";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('s', $token);

        if ($statement->execute() === FALSE) {
            throw new \Exception($this->dbConnection->error, $this->dbConnection->errno);
        }

        return $statement->get_result()->fetch_row()[0];
    }
}