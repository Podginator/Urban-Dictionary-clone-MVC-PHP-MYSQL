<?php

class Admin extends Controller
{


    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION["admin"]) &&  !$_SESSION["admin"] && !UserModel::ValidateUser($this->database)) {
            die("No Admin Rights.");
        }
    }

	protected function loadModel()
    {
        require_once MVC . "/Model/PostModel.php";
        $this->model = new PostModel($this->database);
    }

    public function index($error=null)
    {
        //Check Post Data, if it contains an error print it first.
        if($_SESSION["admin"] && UserModel::ValidateUser($this->database)) {
            require MVC . 'View/template/Header.php';
            require MVC . 'View/template/Nav.php';
            require MVC . 'View/Admin/Admin.php';
            require MVC . 'View/template/Footer.php';
        }
        else
        {
            header("Location:".URL."Login");
        }
    }

    public function MakeAdmin()
    {
        $userModel = new UserModel($this->database);
        $user = $userModel->GetUser($_POST["user"]);

        if($user)
        {
            $userModel->GrantAdmin($user["userid"]);
        }

        header("Location:".URL."Admin");
    }

    public function AddCategory()
    {
        $this->model->AddCategory($_POST["category"]);
    }

}