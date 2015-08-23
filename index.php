<?php
/**
 * @package Places
 * @author Paul Grattan
 */
 
use \Slim\Slim;
use PlaceFinder\Service\Service;

// include the autoloader for composer packages
if (!@include_once('vendor/autoload.php'))
{
    throw new \Exception('Composer autoload and modules are required.');
}

// Router to handle POSTed JSON
$router = new Slim();

$postHandler = new Service();

/**
 * Accept incoming requests on root domain. Ideally the slim router should check 
 * request headers are correct application/json type 
 */
$router->post('/', function() use($router, $postHandler) {
    return $postHandler->parseTradeMessage($router->request->getBody());
});

// Placeholder
$router->get('/', function() {
    return 'Welcome';
});

$router->run();        
