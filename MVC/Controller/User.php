<?php

class User extends Controller
{
	private $postModel = null;
	protected function loadModel()
    {
        require MVC . '/Model/PostModel.php';
        $this->model = new UserModel($this->database);
        $this->postModel = new PostModel($this->database);
    }

    public function index()
    {
    	$user = null;
    	if(isset($_GET["user"]))
    	{
    		$user = $this->model->GetUser($_GET["user"]);
    	}
    	else
    	{
    		if(!UserModel::ValidateUser($this->database))
	    	{
	    		header("Location:".URL."/Login");
	    		return 0;
	    	}
	    	else
	    	{
				$user = $this->model->GetUser($_SESSION["user"]);
			}

    	}

    	if($user==null)
    	{
    		header("Location:".url.'/Header');
    	}

    	$entries = $this->postModel->GetEntriesFromUser($user->username);
    	$replies = $this->postModel->GetRepliesFromUser($user->username);
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/Users/User.php';
        require MVC . 'View/template/Footer.php';
    }

	public function AddBio()
	{
		$user = UserModel::ValidateUser($this->database) ?  $_SESSION["userid"] : null;
		$content = $_POST["Biograpy"];


		$this->model->AddBio($user, $content);

		header("Location:".URL."/User");
	}
}