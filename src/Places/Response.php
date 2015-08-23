<?php

namespace PlaceFinder\Places;

/**
 * Response is used to create a wrapper around the HTTP_Request2 response class
 * and define the type of response json or xml
 *
 * @package Places
 * @author Paul Grattan
 */
class Response
{
    private static $responseTypes = array(
        'xml' => 'application/xml',
        'json' => 'application/json'
    );
    protected $responseType;
    protected $responseCode;
    protected $responseBody;

    /**
     *
     * @param  string $responseType
     * @throws Exception
     */
    public function __construct($responseType = 'json')
    {
        if (!$this->isValidResponseType($responseType)) {
            throw new \Exception('Invalid response type.');
        }
        $this->responseType = $responseType;
    }

    /**
     *
     * @param  string  $responseType
     * @return boolean
     */
    public function isValidResponseType($responseType)
    {
        $type = strtolower($responseType);

        return isset(self::$responseTypes[$type]);
    }

    /**
     * Convenience output method
     * @param string $response
     */
    public function output($response)
    {
        // remove any unexpected output from earlier in the scripts
        @ob_end_clean();
        header('Content-Type: ' . self::$responseTypes[$this->responseType] . '; charset=utf-8');
        echo $response;
    }

    /**
     *
     * @param string $type
     * @param string $value
     */
    public function setHeader($type, $value)
    {
        header($type, $value);
    }

    /**
     * return response http status
     * @return int
     */
    public function getResponseCode()
    {
        return (int) $this->responseCode;
    }

    /**
     *
     * @return string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     *
     * @return string
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     *
     * @return string 
     */
    public function getResponseMimeType()
    {
        if (isset(self::$responseTypes[$this->responseType])) {
            return self::$responseTypes[$this->responseType];
        }

        return null;
    }

}
