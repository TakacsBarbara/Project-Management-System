<?php

class Project
{

    public $name;
    public $description;
    public $status;

    function __construct($name, $description, $status)
    {
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }

    function setDesc($description)
    {
        $this->description = $description;
    }

    function getDesc()
    {
        return $this->description;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function getStatus()
    {
        return $this->status;
    }
}
