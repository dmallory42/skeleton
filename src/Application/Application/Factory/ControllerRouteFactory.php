<?php
/**
 * User: craigpatrick
 * Date: 23/03/2016
 */

namespace Application\Application\Factory;

use Slim\App;
use Slim\Route;

/**
 * Class ControllerRouteFactory
 *
 * @package Application\Application\Factory
 */
class ControllerRouteFactory
{
    /**
     * Function to create controllers based on route configs
     *
     * @param App    $app
     * @param string $type
     * @param string $path
     * @param array  $routeInfo
     *
     * @return Route
     */
    public static function createRouteController(App $app, $type, $path, array $routeInfo)
    {
        /** @var Route $route */
        $route = $app->{$type}($path, "{$routeInfo['controller']}:{$routeInfo['action']}");

        return $route;
    }

    /**
     * Function to add middleware from route config to specified route
     *
     * @param Route $route
     * @param array $middlewareArray
     *
     * @return Route
     */
    public static function addRouteMiddleware(Route $route, array $middlewareArray)
    {
        foreach ($middlewareArray as $middleware) {
            $route->add($middleware);
        }

        return $route;
    }
}