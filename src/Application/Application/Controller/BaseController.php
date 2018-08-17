<?php

namespace Application\Application\Controller;

use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

/**
 * Class BaseController
 *
 * @package Application\Controller
 *
 * @codeCoverageIgnore
 *
 */
class BaseController
{
    /** @var  PhpRenderer $renderer */
    protected $renderer;

    /** @var  Logger */
    protected $logger;

    /**
     * BaseController constructor.
     *
     * @param PhpRenderer   $renderer
     * @param Logger        $logger
     */
    public function __construct(PhpRenderer $renderer, Logger $logger)
    {
        $this->setRenderer($renderer);
        $this->setLogger($logger);
    }

    /*
    |----------------------------------------------------------------------------------------
    | MAIN FUNCTIONS
    |----------------------------------------------------------------------------------------
    */

    /**
     * Base route - returns a "working" response to make sure the app has been installed properly and is running
     *
     * @route /
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $params
     *
     * @return Response
     */
    public function indexGetAction(Request $request, Response $response, $params)
    {
        return $response
            ->write('working')
            ->withStatus(200);
    }

    /**
     * Example showing how to serve an HTML page via controller action.
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $params
     *
     * @return Response
     */
    public function testGetAction(Request $request, Response $response, $params)
    {
        // Example of how to log a message to the /logs folder
        $this->getLogger()->debug('Viewed the index page');

        // Fetch the template we want to render
        $this->getRenderer()->render($response, 'index.phtml');

        // Return the response (with the template)
        return $response
            ->withStatus(200);
    }

    /**
     * Ping route to return a time value - simply used to verify once again it's working
     *
     * @route /ping
     *
     * @param Request  $request
     * @param Response $response
     * @param array    $params
     *
     * @return mixed
     */
    public function pingGetAction(Request $request, Response $response, $params)
    {
        $ping = new \DateTime('now');

        return $response
            ->write($ping->format('D d M Y G:i:s'))
            ->withStatus(200);

    }

    /*
    |----------------------------------------------------------------------------------------
    | GETTERS AND SETTERS
    |----------------------------------------------------------------------------------------
    */

    /**
     * @return PhpRenderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @param PhpRenderer $renderer
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}