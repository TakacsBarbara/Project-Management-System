<?php

class Contact
{

    protected $name;
    protected $email;

    function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getName()
    {
        return $this->name;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function getEmail()
    {
        return $this->email;
    }
    
}
