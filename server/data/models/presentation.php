<?php

namespace Models;

class presentation
{
    private $id;
    private $title;
    private $description;
    private $date;
    private $from;
    private $to;

    public function __construct($id, $title, $description, $date, $from, $to)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->from = $from;
        $this->to = $to;
    }
}