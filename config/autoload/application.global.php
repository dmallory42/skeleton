<?php

/**
 * ======================================================================================================
 * GENERAL APPLICATION CONFIGURATION FILE
 * ======================================================================================================
 *
 * NB: To override these settings, create an application.local.php file from the array
 * below and change any of the settings as you see fit. You can also add additional settings
 * for any new modules etc you want to load by either creating a new config file or by adding
 * them to this file
 */

$logDate = new DateTime();

return [
    'settings' => [
        'displayErrorDetails' => true,

        // Renderer settings
        'renderer' => [
            'template_path' => PROJECT_ROOT . '/templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'application-logger',
            'path' => PROJECT_ROOT . '/logs/' . $logDate->format('d-m-Y') . '.application.log',
        ],
    ],
];