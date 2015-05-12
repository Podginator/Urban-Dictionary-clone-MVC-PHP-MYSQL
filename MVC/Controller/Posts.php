<?php


//This controller is a little bit more abstract as it's used in the Home Page.
class Posts extends Controller
{
    private $userModel = null;
    protected function loadModel()
    {
        require_once MVC . "/Model/PostModel.php";
        $this->model = new PostModel($this->database);
        $this->userModel = new UserModel($this->database);
    }

    public function index($url=null)
    {
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';

        if(!$url)
        {
            require MVC . 'View/template/cookie.php';
            $categories = $this->model->GetCategories();
            $cat = isset($_GET["category"]) ? $_GET["category"] : null;
            require MVC . 'View/Posts/OrganisePosts.php';
            

            $this->RetrievePosts(false, $cat);
        }elseif($url && $this->GetPost($url))
        {
            $this->GetPost($url);
        }


        require MVC . 'View/template/Footer.php';

    }

    public function RetrievePosts($limit=false, $cat = null)
    {

        $postOrder = isset($_COOKIE["cgPref"]) ? $_COOKIE["cgPref"] : "entrydate";
        $allPosts = $this->model->GetAllEntries($postOrder,false,$limit, $cat);
        require MVC . 'View/Posts/Posts.php';
    }

    public function Random()
    {
        //Get all, sort randomly, limit to 1.
        return  $this->model->GetAllEntries("rand()",false,1)[0];

    }

    public function GetRandom()
    {
        $post = $this->Random();
        header("Location:" . URL."/Posts/".$post->id);

    }

    public function GetPost($topic)
    {
        $post = $this->model->GetTopicFromId($topic);
        $replies = $this->model->GetRepliesFromTopic($post->title);
        require MVC.'/View/Posts/GetPost.php';

    }

    public function Topic($topic)
    {
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        $post = $this->model->GetTopic($topic);
        $replies = $this->model->GetRepliesFromTopic($topic);
        require MVC.'/View/Posts/GetPost.php';
        require MVC . 'View/template/Footer.php';
    }

    public function UserPreference($preference)
    {
        $this->model->UserPreferenceCookie($preference);
        if(isset($_COOKIE["cgPref"]))
            $this->RedirectBack();
    }


    public function Add()
    {
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        $postTitle = isset($_GET["topic"]) ? urldecode($_GET["topic"]) : "";
        if(UserModel::ValidateUser($this->database))
        {
            $categories = $this->model->GetCategories();
            require MVC . 'View/Posts/AddPost.php';
        }
        else
        {
             header("Location:".URL.'/Login');
        }

        require MVC . 'View/template/Footer.php';
    }

    public function AddPost()
    {
        $user = UserModel::ValidateUser($this->database) ?  $_SESSION["userid"] : null;
        $content = $_POST["Content"];
        $title = $_POST["Title"];
        $category = $_POST["category"];
        
        $this->model->AddTopic($user, $title, $content, $category);

        header("Location:".URL."/Posts");
    }

    protected function ValidatePost($post)
    {
        if(isset($_SESSION["logged_in"]) &&
            ($_SESSION["admin"] || $_SESSION["user"] == $post["username"])
            && UserModel::ValidateUser($this->database))
        {
            return true;
        }

        return false;
    }

    public function Delete($from, $id)
    {
        $post = $from=="Reply" ? $this->model->GetReplyFromId($id) :$this->model->GetTopicFromId($id);
        if($this->ValidatePost($post))
        {
            if($from=="Reply")
            {
                $this->model->DeleteReply($id);
            }
            else
            {
                $this->model->Delete($id);
            }
        }

        $this->RedirectBack();
    }

}