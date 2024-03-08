<?php

class Router {
    private $baseRoute = '';

    // array to store routes and their associated handling functions
    private $routes = [];

    // defines a route for a specific HTTP method
    // $method <string> - the method, such as GET or POST
    // $pattern <string> - a route, such as /login or /settings/account
    // $handler <function> - the handling function to be executed
    public function match($method, $pattern, $handler){
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;
        
        $this->routes[$method][$pattern] = $handler;
    }

    // shorthand for a route accessed using any method
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function all($pattern, $fn){
        $this->match('GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD', $pattern, $fn);
    }

    // shorthand for a route accessed using GET
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function get($pattern, $fn){
        $this->match('GET', $pattern, $fn);
    }

    // shorthand for a route accessed using POST
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function post($pattern, $fn){
        $this->match('POST', $pattern, $fn);
    }
    
    // shorthand for a route accessed using PATCH
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function patch($pattern, $fn){
        $this->match('PATCH', $pattern, $fn);
    }
    
    // shorthand for a route accessed using DELETE
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function delete($pattern, $fn){
        $this->match('DELETE', $pattern, $fn);
    }
    
    // shorthand for a route accessed using PUT
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function put($pattern, $fn){
        $this->match('PUT', $pattern, $fn);
    }

    public function mount($baseRoute, $fn){
        // track current base route
        $curBaseRoute = $this->baseRoute;

        // build new base route string
        $this->baseRoute .= $baseRoute;

        // call the mount function
        call_user_func($fn);

        // Restore original base route
        $this->baseRoute = $curBaseRoute;
    }

    // handles an incoming request
    // $method <string> - the method, such as GET or POST
    public function handleRequest($method){
        $uri = $this->getCurrentUri();

        // check if there are any routes defined for the requested method
        if(isset($this->routes[$method])){
            // iterate over the routes for the requested method
            // $pattern <string> - a route, such as /login or /settings/account
            // $handler <function> - the handling function to be executed
            foreach($this->routes[$method] as $pattern => $handler) {
                // check if the current pattern matches the requested URI
                if($this->matchPattern($pattern, $uri)){
                    // Extract the captured value from the URI
                    $matches = [];
                    preg_match_all('#^' . $pattern . '$#', $uri, $matches);
                    $id = $matches[1][0]; // Assuming the captured value is at index

                    // if there's a match, execute the associated handler function
                    call_user_func($handler, $id);
                    return;
                }
            }
        }

        // if no route matches, handle as 404 Not Found
        $this->handleNotFound();
    }

    // check if a pattern matches a given URI
    private function matchPattern($pattern, $uri){
        $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
        
        // we may have a match!
        return boolval(preg_match_all('#^' . $pattern . '$#', $uri, $matches, PREG_OFFSET_CAPTURE));
    }

    // returns the current relative URI
    public function getCurrentUri(){
        // remove trailing slash + enforce a slash at the start
        return '/' . trim($_SERVER['REQUEST_URI'], '/');
    }

    // handle 404 Not Found errors
    private function handleNotFound(){
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        
        require_once 'views/err/404.php';
    }
}