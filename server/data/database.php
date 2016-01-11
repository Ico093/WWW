<?php
/**
 * Created by PhpStorm.
 * User: Ico
 * Date: 1/9/2016
 * Time: 21:13
 */

namespace Data;

include_once ROOT . "/config/database.php";

class Database
{
    public $dbConnection;

    public function __construct() {
        // Read the config/database.php db settings
        $host = DB_HOST;
        $username = DB_USERNAME;
        $password = DB_PASSWORD;
        $database = DB_DATABASE;

        $this->dbConnection = new \mysqli( $host, $username, $password, $database );
    }
}