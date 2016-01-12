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
        $sqlQuery = "SELECT p.Id, p.Title, p.Description, p.Date, p.From, p.To FROM presentations p";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->execute();

        $presentations = $statement->get_result()->fetch_all();
        $list = array();
        foreach($presentations as $presentation){
            array_push($list, array('id' => $presentation[0], "title" => $presentation[1]));
        }

        return $list;
    }
}