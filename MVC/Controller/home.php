<?php

require 'Posts.php';

class Home extends Controller
{

    public function index()
    {

        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/template/cookie.php';
        require MVC. 'View/Home/Home.php';

        echo "<div class ='leftContainer'>";
        $posts = new Posts();
        $posts->RetrievePosts(15);
        $posts->GetPost($posts->Random()->id);
        echo "</div>";

        require MVC . 'View/template/Footer.php';
    }
}

