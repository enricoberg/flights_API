<?php

namespace App\Core;
require_once "./app/controllers/FlightsController.php";
require_once "./app/controllers/LocationsController.php";
class Router
{
    public $routes = [
        'GET' => [],
        'POST' => [],
        'PATCH' => [],
        'DELETE' => [],
    ];

    public static function load($file)
    {
        $router = new static;
        require $file;

        return $router;
    }

    public function get($uri, $controller)
    {   
        
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function patch($uri, $controller)
    {
        $this->routes['PATCH'][$uri] = $controller;
    }

    public function delete($uri, $controller)
    {
        $this->routes["DELETE"][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {   
        
        $pattern_flight = '/(?:^|[^\/])flights\/\d+/'; // Define the pattern to match flights/{number}
        $uri= (preg_match($pattern_flight, $uri))? preg_replace($pattern_flight, 'flights', $uri): $uri;
        $pattern_location = '/(?:^|[^\/])locations\/\w+/';         
        $uri= (preg_match($pattern_location, $uri))? preg_replace($pattern_location, 'locations', $uri): $uri;
        
        


        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        throw new \RuntimeException('No route defined for this URI.');
    }
      

    protected function callAction($controller, $action)
    {   
        $controller = "App\\App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (! method_exists($controller, $action)) {
            throw new \RuntimeException(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}

?>