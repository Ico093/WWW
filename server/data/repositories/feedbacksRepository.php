<?php

namespace DataRepositories;

include_once ROOT . '/data/repositories/BaseRepositories/baseRepository.php';

class feedbacksRepository extends baseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFeedbacksByPresentationId($presentationId)
    {
        $sqlQuery = "SELECT f.Content, u.Username FROM feedbacks f INNER JOIN presentations p ON f.PresentationId = p.Id INNER JOIN users u ON f.UserId = u.Id WHERE p.Id = ?";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('i', $presentationId);
        $statement->execute();

        $feedbacksResult = $statement->get_result()->fetch_all();

        $feedbacks = array();
        foreach ($feedbacksResult as $feedback) {
            array_push($feedbacks,
                array(
                    'content' => $feedback[0],
                    'username' => $feedback[1]));
        }

        return $feedbacks;
    }

    public function submitFeedback($presentationId, $userId, $content)
    {

        $sqlQuery = "INSERT INTO feedbacks (UserId, PresentationId, Content) VALUES (?,?,?)";
        $statement = $this->prepareSQL($sqlQuery);
        $statement->bind_param('iis', $userId, $presentationId, $content);

        return $statement->execute();
    }
}