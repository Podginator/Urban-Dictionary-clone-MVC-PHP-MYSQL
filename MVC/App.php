<?php
//Handles the Application Logic.
//Here's where it all comes together.

class App {
    protected $controller = null;
    protected $action = null;
    protected $url_params = array();

    //Constructor should deconstruct the URL to avoid dirty Parameterisation of pages.
    //Therefore we can use a nicer /index/x/y/z/param/ instead of index.php?x=y&z=x&param=45 structure.
    //Ultimately this is just a small readability fix, it's functionality is much the same.
    public function __construct()
    {
        //This method will populate our private variables.
        $this->URLParams();
        $this->getController();
    }

    private function URLParams()
    {
        if (isset($_GET['url'])) {
            $url = trim($_GET['url'], '/');
            $url = explode('/', $url);

            $this->controller = isset($url[0]) ? $url[0] : null;
            $this->action = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $this->url_params = array_values($url);
        }
    }

    private function getController()
    {
        //Go to home if the controller hasn't been set (IE - No /Whatever/ in the URL)
        if ($this->controller === null)
        {
            require MVC . 'controller/home.php';
            $page = new Home();
            $page->index();
        }
        elseif (!file_exists(MVC . 'controller/' . $this->controller .'.php'))
        {
            //File doesn't exist, take to 404 / Error page.
            header('location: ' . URL . 'error');
        } else {
            require MVC . 'controller/' . $this->controller .'.php';

            //Confusing syntaxically, but since php lets us instantiate objects through variables this is fine.
            //What we are doing is instantiating whatever controller the GetURLParams() method found.
            $control = $this->controller;
            $this->controller = new $this->controller();

            //Get Information about the index function to see if it takes parameters or not.
            $reflection = new ReflectionMethod($control, "index");

            //Here we check if there is a method in the controller
            if (strlen($this->action) == 0)
            {
                $this->controller->index();
            }
            elseif (method_exists($this->controller, $this->action))
            {
                //Check if there's a correct method.

                $this->InvokeMethod();
            }
            elseif($reflection->getNumberOfParameters() > 0)
            {
                array_unshift($this->url_params, $this->action);
                call_user_func_array(array($this->controller, "index"), $this->url_params);
            }
            else
            {
                header('location: ' . URL . 'error');
            }
        }
    }


    private function InvokeMethod()
    {
        if (!empty($this->url_params))
        {
            call_user_func_array(array($this->controller, $this->action), $this->url_params);
        }
        else
        {
            $this->controller->{$this->action}();
        }
    }

}