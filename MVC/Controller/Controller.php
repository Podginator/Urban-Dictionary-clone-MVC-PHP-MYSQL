<?php
abstract class Controller {

    protected $model = null;
    //This will be changed to an actual database when we add a SQL db.
    public $database = null;

    function __construct()
    {
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $this->database =  $this->db = new PDO('mysql'.':host='.DBIP.';dbname='.DBNAME.';charset=utf8', DBUSER, DBPASSWORD,$options);

        $this->loadModel();
    }

    protected function loadModel()
    {
        //Could require this in the namespace rather than in this
        require_once MVC .  '/Model/Model.php';

        //Create a new model and pass it the database location.
        $this->model = new Model($this->database);
    }


    protected function RedirectBack()
    {
        $redir = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : URL;
        header('location: ' . $redir);
    }



}