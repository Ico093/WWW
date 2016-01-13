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
        $sqlQuery = "SELECT p.Id, p.Title, p.Description, p.Date, p.From, p.To, u.Username FROM presentations p INNER JOIN users u ON p.UserId = u.Id";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->execute();
        $presentationsResult = $statement->get_result()->fetch_all();

        $presentations = array();
        foreach($presentationsResult as $presentation){
            array_push($presentations,
                array(
                    'id' => $presentation[0],
                    'title' => $presentation[1],
                    'description' =>$presentation[2],
                    'date' => $presentation[3],
                    'from' => $presentation[4],
                    'to' => $presentation[5],
                    'user' => $presentation[6]));
        }

        return $presentations;
    }
}