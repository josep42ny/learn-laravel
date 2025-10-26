<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
  private $routes = [];

  public function route($uri, $method): mixed
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
        Middleware::resolve($route['middleware']);
        return require baseUrl('Http/controllers/' . $route['controller']);
      }
    }
    abort();
  }

  public function only($key)
  {
    $this->routes[array_key_last($this->routes)]['middleware'] = $key;
    return $this;
  }

  private function add($method, $uri, $controller): Router
  {
    $middleware = null;
    $this->routes[] = compact('method', 'uri', 'controller', 'middleware');
    return $this;
  }

  public function get($uri, $controller): Router
  {
    return $this->add('GET', $uri, $controller);
  }

  public function patch($uri, $controller): Router
  {
    return $this->add('PATCH', $uri, $controller);
  }

  public function post($uri, $controller): Router
  {
    return $this->add('POST', $uri, $controller);
  }

  public function delete($uri, $controller): Router
  {
    return $this->add('DELETE', $uri, $controller);
  }
}
