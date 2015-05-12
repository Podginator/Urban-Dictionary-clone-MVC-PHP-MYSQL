<?php

//require_once MVC . "/Model/Entities/User.php";

class UserEntity
{
    public $id;
    public $username;
    public $bio;
    public $email;
    public $last_login;
    public $userdate;
    public $isAdmin;
    public $passwordhash;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['userid'])) ? $data['userid'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->last_login = (!empty($data['last_login'])) ? $data['last_login'] : null;
        $this->bio = (!empty($data['bio'])) ? $data['bio'] : null;
        $this->userdate = (!empty($data['userdate'])) ? $data['userdate'] : null;
        $this->isAdmin = (!empty($data['isAdmin'])) ? $data['isAdmin'] : null;
        $this->passwordhash = (!empty($data['passwordhash'])) ? $data['passwordhash'] : null;

    }

    function __construct($data)
    {
        $this->exchangeArray($data);
    }
}


?>