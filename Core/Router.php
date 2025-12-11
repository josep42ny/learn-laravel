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
      $params = $this->matchPath($route['uri'], $uri);

      if ($params !== null && $route['method'] === strtoupper($method) || $route['uri'] === $uri && $route['method'] === strtoupper($method)) {
        Middleware::resolve($route['middleware']);

        if (!$route['controllerMethod']) {
          return require baseUrl('Http/controllers/' . $route['controller']);
        }

        if ($params) {
          return (new ('Http\controllers\\' . $route['controller']))->{$route['controllerMethod']}($params);
        }

        return (new ('Http\controllers\\' . $route['controller']))->{$route['controllerMethod']}();
      }
    }

    abort();
  }

  // Copiat Laravel
  function matchPath(string $template, string $path): array|null
  {
    $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', $template);
    $regex = "#^$regex$#";

    if (!preg_match($regex, $path, $matches)) {
      return null;
    }

    return array_filter(
      $matches,
      fn($key) => !is_int($key),
      ARRAY_FILTER_USE_KEY
    );
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
