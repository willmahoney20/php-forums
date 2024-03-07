<?php

class Router {
    private $baseRoute = '';

    private $beforeRoutes = array();

    private $afterRoutes = array();

    protected $notFoundCallback = [];

    private $requestedMethod = '';

    public function match($methods, $pattern, $fn){
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->afterRoutes[$method][] = array(
                'pattern' => $pattern,
                'fn' => $fn,
            );
        }
    }

    public function all($pattern, $fn){
        $this->match('GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD', $pattern, $fn);
    }

    public function get($pattern, $fn){
        $this->match('GET', $pattern, $fn);
    }

    public function post($pattern, $fn){
        $this->match('POST', $pattern, $fn);
    }
    
    public function patch($pattern, $fn){
        $this->match('PATCH', $pattern, $fn);
    }
    
    public function delete($pattern, $fn){
        $this->match('DELETE', $pattern, $fn);
    }
    
    public function put($pattern, $fn){
        $this->match('PUT', $pattern, $fn);
    }

    public function run($callback = null){
        // // Define which method we need to handle
        // $this->requestedMethod = $this->getRequestMethod();

        // // Handle all before middlewares
        // if (isset($this->beforeRoutes[$this->requestedMethod])) {
        //     $this->handle($this->beforeRoutes[$this->requestedMethod]);
        // }

        // // Handle all routes
        // $numHandled = 0;
        // if (isset($this->afterRoutes[$this->requestedMethod])) {
        //     $numHandled = $this->handle($this->afterRoutes[$this->requestedMethod], true);
        // }

        // // If no route was handled, trigger the 404 (if any)
        // if ($numHandled === 0) {
        //     $this->trigger404($this->afterRoutes[$this->requestedMethod]);
        // } // If a route was handled, perform the finish callback (if any)
        // else {
        //     if ($callback && is_callable($callback)) {
        //         $callback();
        //     }
        // }

        // // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
        // if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
        //     ob_end_clean();
        // }

        // // Return true if a route was handled, false otherwise
        // return $numHandled !== 0;
    }

    public function set404($match_fn, $fn = null){
        if(!is_null($fn)){
            $this->notFoundCallback[$match_fn] = $fn;
        } else {
            $this->notFoundCallback['/'] = $match_fn;
        }
    }
}