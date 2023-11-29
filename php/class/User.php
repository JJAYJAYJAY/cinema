<?php

class User
{
    private $account;
    private $password;
    private $power;

    public function __construct($account, $password, $power='guest')
    {
        $this->account = $account;
        $this->password = $password;
        $this->power = $power;
    }

    public function login(){

    }

}