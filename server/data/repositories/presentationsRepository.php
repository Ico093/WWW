<?php

namespace DataRepositories;

include_once ROOT.'/data/repositories/BaseRepositories/baseRepository.php';

class presentationsRepository extends baseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPresentations(){
        $sqlQuery = "SELECT p.Id, p.Title, p.Date, p.From, p.To, u.Username FROM presentations p INNER JOIN users u ON p.UserId = u.Id";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->execute();
        $presentationsResult = $statement->get_result()->fetch_all();

        $presentations = array();
        foreach($presentationsResult as $presentation){
            array_push($presentations,
                array(
                    'id' => $presentation[0],
                    'title' => $presentation[1],
                    'date' => $presentation[2],
                    'from' => $presentation[3],
                    'to' => $presentation[4],
                    'username' => $presentation[5]));
        }

        return $presentations;
    }

    public function getPresentationById($id){
        $sqlQuery = "SELECT p.Title, p.Description, p.Date, p.From, p.To, u.Username FROM presentations p INNER JOIN users u ON p.UserId = u.Id WHERE p.Id = $id";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->execute();

        $presentationResult = $statement->get_result()->fetch_assoc();
        $presentation = array_change_key_case($presentationResult, CASE_LOWER);

        return $presentation;
    }

    public function createPresentation($presentation){

        $userId = $this->getUserId($presentation["username"]);
        $title = $presentation["title"];
        $description = $presentation["description"];
        $date = $presentation["date"];
        $from = $presentation["from"];
        $to = $presentation["to"];

        $sql = "INSERT INTO presentations (Title, Description, UserId, Date, From, To) VALUES (?,?,?,?,?,?)";
        $statement = $this->prepareSQL($sql);
        $statement->bind_param('ssssss', $title, $description, $userId, $date, $from, $to);
        return $statement->execute();
    }

    private function getUserId($username){
        $sqlQuery = "SELECT Id FROM users WHERE Username = ?";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('s', $username);
        $statement->execute();
        return $statement->get_result()->fetch_row()[0];
    }
}