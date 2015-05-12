<?php

class Register extends Controller
{

	protected function loadModel()
    {
        $this->model = new UserModel($this->database);
    }


    public function index($error=null)
    {
        //Check Post Data, if it contains an error print it first. 
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/Users/Register.php';
        require MVC . 'View/template/Footer.php';
    }

    public function AddUser()
    {
        $msg = '';

        if($this->model->ValidateRegistration($_POST, $msg))
        {
            $this->model->AddUser($_POST["username"], $_POST["password"], $_POST["email"]);
            $this->Added($msg);
        }
        else
        {
            $this->index($msg);
            return 0;
        }
    }

    public function Added($msg)
    {
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/Users/Added.php';
        require MVC . 'View/template/Footer.php';
    }
}