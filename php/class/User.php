<?php

class User
{
    private $username;
    private $password;
    private $power;
    private $email;
    private $phone;

    public function __construct($username, $password, $power, $email, $phone)
    {
        $this->username = $username;
        $this->password = $password;
        $this->power = $power;
        $this->email = $email;
        $this->phone = $phone;
    }

    public function register($dbc){
        $result=safeBoolQuery($dbc, 'insert into users (username,password,identity,email,phone) values (?,?,?,?,?)', [$this->username,$this->password,$this->power,$this->email,$this->phone]);
        var_dump($result);
        if($result){
            echo "<script>alert('注册成功！');history.go(-1);</script>";
        }else{
            echo "<script>alert('注册失败！');</script>";
        }

    }
    public function login(){
        header("Location:homeTemplate.php");
    }


    public function __toString()
    {
        return "User{" .
            "account='" . $this->username . '\'' .
            ", password='" . $this->password . '\'' .
            ", power='" . $this->power . '\'' .
            ", email='" . $this->email . '\'' .
            ", phone='" . $this->phone . '\'' .
            '}';
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed|string
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

}