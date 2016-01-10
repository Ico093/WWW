<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:47
 */

namespace DataRepositories;

use Data\Database;

include_once '../../database.php';

class baseRepository
{
    protected $dbConnection;

    protected function __construct()
    {
        $database = new Database();
        $this->dbConnection = $database->get_dbConnection();
    }

    protected function prepareSQL($sql)
    {
        return $this->dbConnection->prepare($sql);
    }

    protected function queryDB($sql)
    {
        return $this->dbConnection->query($sql);
    }
}