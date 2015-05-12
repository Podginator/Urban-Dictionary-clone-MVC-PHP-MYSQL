<?php

require_once MVC . "/Model/Entities/Post.php";
require_once MVC . "/Model/Entities/Users.php";


class Model
{

    function __construct($database)
    {
         try {
			$this->database = $database;
		} catch (PDOException $e) {
			exit('NO DB');
		}
    }

    //Some Abstracted out functions
    protected function FetchAll($SQL, $optionsArr=array(), $entity=null)
    {
        $query = $this->ExecQuery($SQL, $optionsArr);
        $res = $this->ObjectifyResults($query->fetchAll(),$entity);
        return $res;
    }

    protected function Fetch($SQL, $optionsArr=array(),$entity=null)
    {
        $query = $this->ExecQuery($SQL, $optionsArr);
        $res = $this->ObjectifyResults($query->fetch(),$entity);
        return $res;
    }

    protected function ExecQuery($SQL, $optionsArr=array())
    {
        $query = $this->database->prepare($SQL);
        $query->execute($optionsArr);
        return $query;
    }

    protected function ObjectifyResults($data, $class=null)
    {
        if(!$data)
        {
            return $data;
        }
        $res = null;
        if(!$class)
        {
            return $data;
        }

        if(isset($data[0]) && is_array($data[0]))
        {
            $res = array();
            foreach($data as $datum)
            {
                array_push($res, new $class($datum));
            }
        }
        else
        {
            $res = new $class($data);
        }

        return $res;

    }

}