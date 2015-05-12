<?php

require_once MVC . "/Model/Entities/Post.php";

class ReplyEntity extends PostEntity
{
    public $replyId;

    public function exchangeArray($data)
    {
        parent::exchangeArray($data);
        $this->replyid = (!empty($data['replyid'])) ? $data['replyid'] : null;
    }
    
    function __construct($data)
    {
        $this->exchangeArray($data);
    }
}
?>