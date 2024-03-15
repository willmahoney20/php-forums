<?php

class Router {
    private $baseRoute = '';

    // array to store routes and their associated handling functions
    private $routes = [];

    // defines a route for a specific HTTP method
    // $methods <string> - the method, such as GET or POST, delimited by '|'
    // $pattern <string> - a route, such as /login or /settings/account
    // $handler <function> - the handling function to be executed
    public function match($methods, $pattern, $handler){
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach(explode('|', $methods) as $method){
            $this->routes[$method][$pattern] = $handler;
        }
    }

    // shorthand for a route accessed using any method
    // $pattern <string> - a route pattern such as /about/system
    // $fn <function> - a handling function to be executed
    public function all($pattern, $fn){
        $this->match('GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD', $pattern, $fn);
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

    // get all request headers.
    public function getRequestHeaders(){
        $headers = array();

        // if getallheaders() is available, use that
        if(function_exists('getallheaders')){
            $headers = getallheaders();

            // getallheaders() can return false if something went wrong
            if($headers !== false) return $headers;
        }

        // method getallheaders() not available or went wrong: manually extract 'm
        foreach($_SERVER as $name => $value){
            if((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')){
                $headers[str_replace(array(' ', 'Http'), array('-', 'HTTP'), ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        return $headers;
    }

    // get the request method used, taking overrides into account
    public function getRequestMethod(){
        // take the method as found in $_SERVER
        $method = $_SERVER['REQUEST_METHOD'];

        // if it's a HEAD request, override it to GET and prevent any output, as per HTTP Specification
        if($_SERVER['REQUEST_METHOD'] == 'HEAD'){
            ob_start();
            $method = 'GET';
        }

        // if it's a POST request, check for a method override header
        elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $headers = $this->getRequestHeaders();
            if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], array('PUT', 'DELETE', 'PATCH'))) {
                $method = $headers['X-HTTP-Method-Override'];
            }
        }

        return $method;
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
        // Remove query parameters from the URI for comparison
        $uriWithoutParams = strtok($uri, '?');

        $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
        
        // we may have a match!
        return boolval(preg_match_all('#^' . $pattern . '$#', $uriWithoutParams, $matches, PREG_OFFSET_CAPTURE));
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