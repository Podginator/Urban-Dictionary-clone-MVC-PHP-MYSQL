<?php

class Search extends Controller
{

	protected function loadModel()
    {
        require_once MVC . "/Model/PostModel.php";
        $this->model = new PostModel($this->database);
    }

    public function index()
    {
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        $allPosts = $this->model->FindTopics($_POST["term"]);
        require MVC . 'View/Search/search.php';
        $this->FindPosts($_POST["term"], $allPosts);

        require MVC . 'View/template/Footer.php';
    }

    protected function FindPosts($terms, $allPosts)
    {
        $allPosts = $this->model->FindTopics($terms);
        require MVC.'View/Posts/Posts.php';
    }

    protected function FindUsers($terms)
    {

    }

    public function Post($term)
    {

    }

    public function Users($term)
    {

    }

}