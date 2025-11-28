<?php

namespace Core;

use Core\Middleware\Middleware;
use Http\controllers;

class Router
{
  private $routes = [];

  public function route($uri, $method)
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
        Middleware::resolve($route['middleware']);

        $route['controllerMethod'] ? (new ('Http\controllers\\' . $route['controller']))->{$route['controllerMethod']}() : null;

        return require baseUrl('Http/controllers/' . $route['controller']);
      }
    }

    abort(404);
  }

  public function only($key)
  {
    $this->routes[array_key_last($this->routes)]['middleware'] = $key;
    return $this;
  }

  private function add($method, $uri, $controller, $controllerMethod = null): Router
  {
    $middleware = null;
    $this->routes[] = compact('method', 'uri', 'controller', 'middleware', 'controllerMethod');
    return $this;
  }

  public function get($uri, $controller,  $controllerMethod = null): Router
  {
    return $this->add('GET', $uri, $controller, $controllerMethod);
  }

  public function patch($uri, $controller,  $controllerMethod = null): Router
  {
    return $this->add('PATCH', $uri, $controller, $controllerMethod);
  }

  public function post($uri, $controller,  $controllerMethod = null): Router
  {
    return $this->add('POST', $uri, $controller, $controllerMethod);
  }

  public function delete($uri, $controller,  $controllerMethod = null): Router
  {
    return $this->add('DELETE', $uri, $controller, $controllerMethod);
  }

  public function previousUrl()
  {
    return $_SERVER['HTTP_REFERER'];
  }
}
