<?php

namespace Application\Application\Service;

use Application\Application\DiContainer\Dependencies;
use Application\Application\Factory\ControllerRouteFactory;
use Slim\App;

/**
 * Class AppService
 * @package Vast\Application\Service
 */
class AppService
{

    /**
     * @var App $slimApp
     */
    protected $slimApp;

    /**
     * @var array
     */
    protected $routes = [];

    /*
    |----------------------------------------------------------------------------------------
    | MAIN SETUP FUNCTIONS
    |----------------------------------------------------------------------------------------
    */

    /**
     * Add routes to the Slim router
     *
     * @codeCoverageIgnore
     *
     * @return bool
     */
    protected function addRoutes()
    {
        foreach (self::getRoutes() as $type => $routes) {
            foreach ($routes as $path => $routeInfo) {

                // Define our route object:
                $route = ControllerRouteFactory::createRouteController($this->slimApp, $type, $path, $routeInfo);

                // Assign any Middleware for this route:
                if ($routeInfo['mw']) {
                    $route = ControllerRouteFactory::addRouteMiddleware($route, $routeInfo['mw']);
                }

                // Set the route name:
                $route->setName($routeInfo['name']);
            }

        }

        return true;
    }

    /**
     * Function to auto load all configs into a container for Slim
     */
    public function autoloadConfigFiles()
    {
        $globalConfig = [];
        $localConfig = [];

        $globalFiles = glob('config/autoload/*.global.php');
        $localFiles = glob('config/autoload/*.local.php');

        foreach ($globalFiles as $globalFile) {
            /** @noinspection PhpIncludeInspection */
            $globalConfig = array_merge_recursive($globalConfig, require($globalFile));
        }

        if (isset($localConfig)) {
            foreach ($localFiles as $localFile) {
                /** @noinspection PhpIncludeInspection */
                $localConfig = array_merge_recursive($localConfig, require($localFile));
            }
        }

        $config = array_replace_recursive($globalConfig, $localConfig);

        // Set the config:
        return $config;
    }

    /**
     * Function to set any dependency injection modules we may want
     *
     * We can ignore this in code coverage as we're only actually testing Slim's
     * ability to create a container which is already tested
     *
     * @codeCoverageIgnore
     */
    public function setDi()
    {
        Dependencies::initDependencyInjection($this->getSlimApp());
    }


    /**
     * @param bool $run
     *
     * @return bool
     */
    public function initialise($run = true)
    {
        $this->addRoutes();
        if ($run) {
            $this->getSlimApp()->run();
        }
        return true;
    }

    /*
    |----------------------------------------------------------------------------------------
    | GETTERS AND SETTERS
    |----------------------------------------------------------------------------------------
    */

    /**
     * @return App
     */
    public function getSlimApp()
    {
        return $this->slimApp;
    }

    /**
     * @param App $slimApp
     */
    public function setSlimApp($slimApp)
    {
        $this->slimApp = $slimApp;
    }

    /**
     * @param $controllerName
     *
     * @return mixed
     */
    public function getController($controllerName)
    {
        $controller = $controllerName;
        return new $controller($this->getSlimApp());
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }
}
