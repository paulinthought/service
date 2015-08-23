<?php
/**
 * Accepts a GET request, forwards it to Google API and returns result
 * 
 * @package Places
 * @author Paul Grattan
 */

use PlaceFinder\Places as Places;

// include the autoloader for composer packages
if (!@include_once('vendor/autoload.php'))
{
    //fallback to pear global install
    if (!@require_once 'HTTP/Request2.php')
    {
        throw new \Exception('HTTP_Request2 is required for this module. Run composer install');
    }
}

$request = new Places\Request();

$params = Places\Sanitize::arrayKeysToLower($_GET);

if (isset($params['find'])) 
{
    $request->setFindQuery( $params['find'], isset($params['autocomplete']) );
}

$request->respond();
