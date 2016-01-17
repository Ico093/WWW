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
        $sqlQuery = "SELECT p.Id, p.Title, p.OnDate, p.FromTime, p.ToTime, u.Username FROM presentations p INNER JOIN users u ON p.UserId = u.Id";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->execute();
        $presentationsResult = $statement->get_result()->fetch_all();

        $presentations = array();
        foreach($presentationsResult as $presentation){
            array_push($presentations,
                array(
                    'id' => $presentation[0],
                    'title' => $presentation[1],
                    'ondate' => $presentation[2],
                    'fromtime' => $presentation[3],
                    'totime' => $presentation[4],
                    'username' => $presentation[5]));
        }

        return $presentations;
    }

    public function getPresentationById($id){
        $sqlQuery = "SELECT p.Title, p.Description, p.OnDate, p.FromTime, p.ToTime, u.Username FROM presentations p INNER JOIN users u ON p.UserId = u.Id WHERE p.Id = $id";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->execute();

        $presentationResult = $statement->get_result()->fetch_assoc();
        $presentation = array_change_key_case($presentationResult, CASE_LOWER);

        return $presentation;
    }

    public function createPresentation($presentation){

        $userId = $presentation["userId"];
        $title = $presentation["title"];
        $description = $presentation["description"];
        $ondate = date("Y-m-d H:i:s", strtotime($presentation["ondate"]));
        $fromtime = $presentation["fromtime"];
        $totime = $presentation["totime"];

        $sqlQuery = "INSERT INTO presentations (Title, Description, UserId, OnDate, FromTime, ToTime) VALUES (?,?,?,?,?,?)";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('ssisdd', $title, $description, $userId, $ondate, $fromtime, $totime);

        return $statement->execute();
    }

    public function updatePresentation($id, $presentation){
        $title = $presentation["title"];
        $description = $presentation["description"];
        $ondate = date("Y-m-d H:i:s", strtotime($presentation["ondate"]));
        $fromtime = $presentation["fromtime"];
        $totime = $presentation["totime"];

        $sqlQuery = "UPDATE presentations SET Title = ?, Description = ?, OnDate = ?, FromTime = ?, ToTime = ? WHERE Id = ? ";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('sssddi', $title, $description, $ondate, $fromtime, $totime, $id);

        return $statement->execute();
    }

    public function deletePresentation($id){
        $sqlQuery = "DELETE p FROM presentations AS p WHERE p.Id = ?";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('i', $id);
        return $statement->execute();
    }
}