<?php

require_once("Model.php");
require_once MVC . "/Model/Entities/Post.php";
require_once MVC . "/Model/Entities/Reply.php";



class PostModel extends Model
{
    //This is reused a lot, best to push it out to it's own variable.
    protected $getPost = "SELECT ENTRY.entryname as title,
                ENTRY.entryid as id,
                ENTRY.entrycontent as content,
                ENTRY.entrydate as date,
                ENTRY.category,
                USER.username";

    protected $defaultEntity = "PostEntity";

    public function GetEntriesFromUser($user)
    {
        $SQL = $this->getPost.
                " FROM ENTRY
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE USER.username = :username";
        $param = array(':username'=>$user);

        return $this->FetchAll($SQL, $param,$this->defaultEntity);
    }

    public function GetRepliesFromUser($user)
    {
        $SQL = "SELECT ENTRY.entryname as title,
                        ENTRY.entryid as id,
                        ENTRYREPLIES.replyid,
                        ENTRYREPLIES.replycontent as content,
                        ENTRYREPLIES.replydate as date,
                        USER.username
                FROM ENTRYREPLIES
                LEFT JOIN ENTRY
                    ON ENTRY.entryid = ENTRYREPLIES.entryid
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE USER.username = :username";

        $param = array(':username'=>$user);


        return $this->FetchAll($SQL, $param, "ReplyEntity");
    }

    public function GetAllEntries($order = null, $asc = false, $limit = false, $cat=null)
    {
        $SQL = $this->getPost.",COUNT(ENTRYREPLIES.replyid) AS cnt_replies
                FROM ENTRY
                LEFT JOIN ENTRYREPLIES
                    ON ENTRY.entryid = ENTRYREPLIES.entryid
                INNER JOIN USER ON USER.userid=ENTRY.userid";

        $SQL .= $cat ? " WHERE ENTRY.category = :cat" : " ";

        $SQL .= " GROUP BY ENTRY.entryid ";
        //Validate orders
        $possOrder=array("entryname","entrydate","lastupdated", "username", "cnt_replies", "rand()");
        $key = array_search($order, $possOrder);
        $SQL .= $key ? " ORDER BY {$order} " : "";
        $SQL .= $key && $asc ? "ASC" : "DESC";
        $SQL .= $limit && is_int($limit) ? " LIMIT {$limit} " : "";

        $arr = $cat ? array(":cat" => $cat) : array();
        return $this->FetchAll($SQL, $arr , $this->defaultEntity);
    }

    public function GetCategories()
    {
        $SQL = "SELECT * FROM CATEGORIES";
        //Validate orders
        return $this->FetchAll($SQL);

    }

    public function GetTopic($topic)
    {
        $SQL = $this->getPost.", COUNT(ENTRYREPLIES.replyid) AS cnt_replies
                FROM ENTRY
                LEFT JOIN ENTRYREPLIES
                    ON ENTRY.entryid = ENTRYREPLIES.entryid
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE ENTRY.entryname = :entry
                GROUP BY ENTRY.entryid";
        //Validate orders
        return $this->Fetch($SQL, array(":entry" => $topic), $this->defaultEntity);
    }

    public function GetTopicFromId($id)
    {
        $SQL = $this->getPost.
                " FROM ENTRY
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE ENTRY.entryid = :entry";

        return $this->Fetch($SQL, array(":entry" => $id), $this->defaultEntity);
    }

    public function AddTopic($user, $title, $content, $category=null)
    {

        $getTopic = $this->GetTopic($title);
        echo print_r($getTopic);
        if($getTopic)
        {
            echo "Hi";
            $SQL =  "INSERT INTO ENTRYREPLIES (userid,
                  entryid,
                  replycontent)
                  VALUES (:userid,
                  :entryid,
                  :replycontent)";
            $options = array(":entryid"=>$getTopic->id, ":replycontent"=>$content, ":userid"=>$user);
        }
        else
        {
            $SQL =  "INSERT INTO ENTRY (entryname,
                  entrycontent,
                  userid,
                  category)
                  VALUES (:entryname,
                  :entrycontent,
                  :userid,
                  :cat)";
            $options = array(":entryname"=>$title, ":entrycontent"=>$content, ":userid"=>$user,":cat"=>$category);

        }
        $this->ExecQuery($SQL, $options);
    }

    public function GetRepliesFromTopic($topic, $limit=false)
    {
        $SQL = "SELECT ENTRY.entryname as title,
                        ENTRYREPLIES.replycontent as content,
                        ENTRYREPLIES.replydate as date,
                        ENTRYREPLIES.replyid,
                        ENTRY.entryid as id,
                        ENTRYREPLIES.lastupdated,
                        USER.username
                FROM ENTRYREPLIES
                LEFT JOIN ENTRY
                    ON ENTRY.entryid = ENTRYREPLIES.entryid
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE ENTRY.entryname = :entry";

        $options = array(":entry" => $topic);
        return $this->FetchAll($SQL, $options, "ReplyEntity");
    }

    public function GetReplyFromId($id)
    {
        $SQL = "SELECT ENTRY.entryname as title,
                        ENTRYREPLIES.replycontent as content,
                        ENTRYREPLIES.replydate as date,
                        ENTRYREPLIES.replyid as id,
                        ENTRY.entryid as parentid,
                        ENTRYREPLIES.lastupdated,
                        USER.username
                FROM ENTRYREPLIES
                LEFT JOIN ENTRY
                    ON ENTRY.entryid = ENTRYREPLIES.entryid
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE ENTRYREPLIES.replyid = :entry";

        return $this->Fetch($SQL, array(":entry" => $id), "ReplyEntity");
    }

    public function Delete($topicid)
    {
        //We have a cascading update /delete list. So this should delete all "Replies".
        $SQL = "DELETE FROM ENTRY WHERE ENTRY.entryid = :id";

        $options = array(":id" => $topicid);
        $this->ExecQuery($SQL, $options);
    }

    public function DeleteReply($replyid)
    {
        $SQL = "DELETE FROM ENTRYREPLIES WHERE replyid = :id";

        $options = array(":id" => $replyid);
        $this->ExecQuery($SQL, $options);
    }

    public function UserPreferenceCookie($val)
    {
        if($val != "Chronological" && $val != "Popularity" )
        {
            return false;
        }
        $val = $val == "Chronological" ? "entrydate" : "cnt_replies";
        setcookie("cgPref", $val,time()+31556926 , '/');

    }

    public function FindTopics($topic)
    {
        $SQL = $this->getPost.
                " FROM ENTRY
                INNER JOIN USER ON USER.userid=ENTRY.userid
                WHERE ENTRY.entryname LIKE :id";

        $options = array(":id" => "%".$topic."%");

        return $this->FetchAll($SQL, $options, $this->defaultEntity);
    }


}