<?php

class Login extends Controller
{

	protected function loadModel()
    {
        $this->model = new UserModel($this->database);
    }

    public function index($error=null)
    {
        //Check Post Data, if it contains an error print it first.
        $redir = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : URL;
 
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/Users/Login.php';
        require MVC . 'View/template/Footer.php';
    }

    public function LogOut()
    {
        $this->model->LogOut();

        $this->RedirectBack();
    }

    public function LogOn()
    {
        $redir = $_GET["redir"];

        if($this->model->LoginUser($_POST["username"], $_POST["password"]))
        {
           header("Location:" . $redir);
        }
        else
        {
            $this->index("Error Logging On, incorrect username or password");
            return 0;
        }



    }

}