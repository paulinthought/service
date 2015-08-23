<?php
/**
 * Service is used as an endpoint for a local RESTful API provider
 * It passes values over to the node socket server
 * This PHP framework would be an ideal place to persist or modify the data 
 * before it's sent to the dasboard. 
 *
 * @package Service
 * @author Paul Grattan
 */

namespace PlaceFinder\Service;
use PlaceFinder\Places;

class Service
{
    
    /**
     *
     * @param  string  $jsonString
     * @return boolean
     */
    public function parseTradeMessage($jsonString)
    {
        // TODO: Usually we'd use some sort of tradeMessage model here to validate 
        // the data structure
        $messageData = Places\Transform::jsonToArray($jsonString);
        // TODO: We should also sanitize the content of the JSON by checking for expected types
        return $this->passMessageToSocketServer($messageData);
    }

    private function passMessageToSocketServer($messageData) {

        // put the data received to the filesystem for node server to pick up
        $sock = stream_socket_client('unix:///tmp/node_socket', $errno, $errstr);
        fwrite($sock, json_encode($messageData)."\n");
        if ($errno) 
        {
            throw new Exception($errstr, $errno);
        }
        return true;
    }

}
