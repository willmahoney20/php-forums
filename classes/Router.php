<?php

class Router {
    // array to store routes and their associated handling functions
    private $routes = [];

    // defines a route for a specific HTTP method
    // $method <string> - the method, such as GET or POST
    // $pattern <string> - a route, such as /login or /settings/account
    // $handler <function> - the handling function to be executed
    public function addRoute($method, $pattern, $handler){
        $this->routes[$method][$pattern] = $handler;
    }

    // handles an incoming request
    // $method <string> - the method, such as GET or POST
    // $uri <string> - the route the page is trying to access, such as /login
    public function handleRequest($method, $uri){
        // check if there are any routes defined for the requested method
        if(isset($this->routes[$method])){
            // iterate over the routes for the requested method
            // $pattern <string> - a route, such as /login or /settings/account
            // $handler <function> - the handling function to be executed
            foreach($this->routes[$method] as $pattern => $handler) {
                // check if the current pattern matches the requested URI
                if($this->matchPattern($pattern, $uri)){
                    // if there's a match, execute the associated handler function
                    call_user_func($handler);
                    return;
                }
            }
        }

        // if no route matches, handle as 404 Not Found
        $this->handleNotFound();
    }

    // check if a pattern matches a given URI
    private function matchPattern($pattern, $uri){
        // perform simple string comparison for now
        return $pattern === $uri;
    }

    // handle 404 Not Found errors
    private function handleNotFound(){
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        
        require 'views/404.php';
    }
}