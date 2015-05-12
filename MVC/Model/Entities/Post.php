<?php

require_once MVC . "/Model/Entities/Users.php";

class PostEntity
{
    public $id;
    public $content;
    public $title;
    public $date;
    public $category;
    public $user;
    public $countReplies;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->content = (!empty($data['content'])) ? $data['content'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
        $this->category = (!empty($data['category'])) ? $data['category'] : null;
        $this->date = (!empty($data['date'])) ? $data['date'] : null;
        $this->countReplies = (!empty($data['cnt_replies'])) ? $data['cnt_replies'] : null;

        if(!empty($data["userid"]) || !empty($data["username"]))
        {
            //We only need a $username
            $this->user = new UserEntity(array("username" => $data["username"]));
        }
    }

    function __construct($data)
    {
        $this->exchangeArray($data);
    }
}


?>