<?php

return array(
    /**
     * This routing config system has been built so you can define routes in an easy and dynamic manner
     *
     * Basically takes the following format:
     *
     * [TYPE] => (this can be GET, POST, PUT etc)
     *          [PATH] => (this will be your entry point, such as /index, /test etc
     *              [CONTROLLER] - (the NAME of the controller to use for the action - MUST be declared and added as a Dependency in Dependencies Class)
     *              [ACTION] - (the name of the method run within the specified controller)
     *              [NAME] - (The name of the route)
     *              [MW] - (optional - boolean / array of middleware) - used to indicate if the route should load custom middleware or not.
     *                              The middleware must exist and be registered as a container in Slim for it to load
     *
     * For example:
     *
     * 'post' => array(
     *      '/' => array(
     *              'controller' => 'ApplicationController',
     *              'action' => 'index',
     *              'name' => 'my.route.name',
     *              'mw' => false / ['myMiddleware'];
     *             ),
     *      ),
     *
     * These routes can also accept optional parameters as usual with Slim
     * such as /index(/:something)
     */

    'routes' => array(

        // POST ROUTES ------------------------------------------------------------------------
        'post' => array(

        )
    )
);