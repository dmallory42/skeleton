<?php
/**
 * User: craigpatrick
 * Date: 17/03/2016
 */

namespace Application\Application\DiContainer;

use AdspruceMiddleware\Middleware\Device\DeviceMiddleware;
use AdspruceMiddleware\Middleware\Geo\GeoMiddleware;
use Application\Application\Controller\BaseController;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Container;
use Slim\Views\PhpRenderer;

/**
 * Class Dependencies
 *
 * @package DiContainer
 *
 * @codeCoverageIgnore
 */
class Dependencies
{
    /**
     * @param App $app
     */
    public static function initDependencyInjection(App $app)
    {
        $container = $app->getContainer();

        // -- CONTROLLERS
        // ----------------------------------------------------------------------------------------
        $container[BaseController::class] = function (ContainerInterface $c) {
            $renderer = $c->get(PhpRenderer::class);
            $logger  =  $c->get(Logger::class);
            return new BaseController($renderer, $logger);
        };

        // -- MIDDLEWARE
        // ----------------------------------------------------------------------------------------
        $container[DeviceMiddleware::class] = function (ContainerInterface $c) {
            /** @var Container $c */
            $config = $c->get('data');

            return new DeviceMiddleware($config['lookup']);
        };

        $container[GeoMiddleware::class] = function (ContainerInterface $c) {
            /** @var Container $c */
            $config = $c->get('data');

            return new GeoMiddleware($config['lookup']);
        };

        // -- SERVICES
        // ----------------------------------------------------------------------------------------
        // View Renderer
        $container[PhpRenderer::class] = function (ContainerInterface $c) {
            /** @var Container $c */
            $settings = $c->get('settings')['renderer'];

            return new PhpRenderer($settings['template_path']);
        };

        // MonoLog
        $container[Logger::class] = function (ContainerInterface $c) {
            /** @var Container $c */
            $settings = $c->get('settings')['logger'];
            $logger   = new Logger($settings['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($settings['path'], Logger::DEBUG));

            return $logger;
        };
    }
}