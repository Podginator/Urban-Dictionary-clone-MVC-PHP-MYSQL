<?php

class error extends Controller
{
    public function index()
    {
        require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/template/Error.php';
        require MVC . 'View/template/Footer.php';
    }

    static public function Exception($exception)
    {
    	$exception = $exception;
    	require MVC . 'View/template/Header.php';
        require MVC . 'View/template/Nav.php';
        require MVC . 'View/template/Error.php';
        require MVC . 'View/template/Footer.php';
    }
}