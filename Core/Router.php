<?php

namespace Core;

class Router
{
  private $routes = [];

  public function route($uri, $method): mixed
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
        return require baseUrl($route['controller']);
      }
    }
    abort();
  }

  private function add($method, $uri, $controller): void
  {
    $this->routes[] = compact('method', 'uri', 'controller');
  }

  public function get($uri, $controller): void
  {
    $this->add('GET', $uri, $controller);
  }

  public function put($uri, $controller): void
  {
    $this->add('PUT', $uri, $controller);
  }

  public function post($uri, $controller): void
  {
    $this->add('POST', $uri, $controller);
  }

  public function delete($uri, $controller): void
  {
    $this->add('DELETE', $uri, $controller);
  }
}
