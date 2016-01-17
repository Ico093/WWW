<?php

namespace DataRepositories;

include_once ROOT.'/data/repositories/BaseRepositories/baseRepository.php';

class feedbacksRepository extends baseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function submitFeedback($username, $presentationId, $content){
        $userId = $this->getUserId($username);

        $sqlQuery = "INSERT INTO feedbacks (UserId, PresentationId, Content) VALUES (?,?,?)";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('iis',$userId, $presentationId, $content);

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