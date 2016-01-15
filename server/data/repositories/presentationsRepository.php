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
                    'user' => $presentation[5]));
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
}