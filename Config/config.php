<?php
	define('MVC', dirname(__DIR__) . '/' . 'MVC' . '/');
	define('URL_PUBLIC_FOLDER', '');
	define('URL_PROTOCOL', 'http://');
	define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
	define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
	define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER . '/');
	require MVC . 'App.php';
	require MVC . 'Controller/Controller.php';


	define('DBUSER', "root");
	define("DBPASSWORD", "");
	define("DBNAME", "tomrogersudict");
	define("DBIP", "127.0.0.1");
