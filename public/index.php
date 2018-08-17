<?php

date_default_timezone_set('Europe/London');

define('PROJECT_ROOT', realpath(__DIR__ . '/..'));

chdir('../');
require_once(PROJECT_ROOT . '/vendor/autoload.php');
session_start();

/*
|----------------------------------------------------------------------------------------
| ADD OUR GLOBAL PR OBJECT IF NEEDED
|----------------------------------------------------------------------------------------
*/

function pr($object, $printR = false)
{
    echo '<pre>';
    if ($printR) {
        print_r($object);
    } else {
        var_dump($object);
    }

    die('</pre>');
}

/*
|----------------------------------------------------------------------------------------
| INSTANTIATE THE APPLICATION
|----------------------------------------------------------------------------------------
*/

$appService = new \Application\Application\Service\AppService();
$config = $appService->autoloadConfigFiles();

/** @var \Slim\App $slimApp */
$slimApp = new \Slim\App($config);
$appService->setSlimApp($slimApp);

/*
|----------------------------------------------------------------------------------------
| RUN APPLICATION SETUP
|----------------------------------------------------------------------------------------
*/

$appService->setDi();

/*
|----------------------------------------------------------------------------------------
| MIDDLEWARE
|----------------------------------------------------------------------------------------
*/

// Add our custom Middleware to look at Device and IP Lookup
$slimApp->add(\AdspruceMiddleware\Middleware\Device\DeviceMiddleware::class);
$slimApp->add(\AdspruceMiddleware\Middleware\Geo\GeoMiddleware::class);

/*
|----------------------------------------------------------------------------------------
| ROUTES
|----------------------------------------------------------------------------------------
*/

$appService->setRoutes($appService->getSlimApp()->getContainer()['routes']);

/*
|----------------------------------------------------------------------------------------
| INITIALISE AND RUN
|----------------------------------------------------------------------------------------
*/

try {
    $appService->initialise();
} catch (Exception $e) {
    // Something has gone wrong, so we need to return an error as XML:
    // @todo: this needs to be updated with proper error output
    pr($e->getMessage());
}
