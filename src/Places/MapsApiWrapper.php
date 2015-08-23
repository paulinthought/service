<?php
/**
 *
 * @package Places
 * @extends Response
 * @author Paul Grattan
 */

namespace PlaceFinder\Places;

class MapsApiWrapper extends Response
{
    const API_KEY = '';

    protected $mapsUri = 'https://maps.googleapis.com';
    protected $queryPath = array(
        'places' => '/maps/api/place/textsearch/',
        'autocomplete' => '/maps/api/place/autocomplete/'
    );
    private $params = array();
    private $query;
    private $request;

    /**
     *
     * @param string $responseType
     */
    public function __construct($request, $responseType = 'json')
    {
        parent::__construct($responseType);
        // initialise autocomplete default
        $this->request = $request;
        
    }

    /**
     * Set up params and initiate call to places api
     * @param string $input
     */
    public function callPlacesApi()
    {
        $this->params = array(
            'key' => self::API_KEY,
            'sensor' => 'false',
            'type' => 'establishment',
            'regions' => 'cities'
        );
        
        $queryType = $this->request->getAutoComplete() ? 'input' : 'query';
        $this->params[$queryType] = $this->request->getFindQuery();
        
        $this->makeApiRequest();
    }

    /**
     * Concatenate parts of the query to be used in the api call to google
     */
    protected function buildQuery()
    {
        $apiCall = ($this->request->getAutoComplete()) ? 'autocomplete' : 'places';
        
        $paramString = http_build_query($this->params);

        $this->query = $this->mapsUri .
                $this->queryPath[$apiCall] .
                (string) $this->getResponseType() .
                '?' . (string) $paramString;
    }

    /**
     * Call the places Api with the url from builQuery() and handle the response
     */
    private function makeApiRequest()
    {
        $this->buildQuery();

        $request = new \HTTP_Request2($this->query, \HTTP_Request2::METHOD_GET);
        $request->setConfig(array('ssl_verify_peer' => false));

        try {

            $response = $request->send();
            $this->responseCode = $response->getStatus();
            $this->responseBody = $response->getBody();

            if ((int) $this->responseCode !== 200) {

                $this->responseBody = json_encode(
                        array("error" => "Sorry. We encountered a " . $this->responseCode . " code from the maps api")
                );
            }
            $this->validateJsonResponseData();
        } catch (Exception $e) {

            // We wouldn't usually expose this error to the user
            // log $e->getMessage()
            $this->responseCode = 500;
            $this->responseBody = json_encode(
                    array('error' => 'An internal error occurrred. Please try again.')
            );
        }
    }

    /**
     * Check the status element in the returned json
     * @return boolean
     * @throws Exception
     */
    protected function validateJsonResponseData()
    {
        $data = Transform::jsonToArray($this->responseBody);

        if (!isset($data['status'])) {
            throw new \Exception("An error has occurred validating the response");
        }
        
        switch(strtolower($data['status'])) {
            
            case "ok":
                return true;
            case "invalid_request": 
                // throw new \Exception("An error has occurred. Response status not ok");
            default:
                return false;
        }
       
    }

    /**
     * create a JSON string from our modified result from google api
     *
     * @return string
     */
    private function parseResponse()
    {
        $response = array();
        $response['places'] = array();

        $data = Transform::jsonToArray($this->responseBody);

        if ($this->request->getAutoComplete()) {
            if (isset($data['predictions'])) {

                foreach ($data['predictions'] as $result) {
                    $response['places'][] = $result['description'];
                }
            }
        } else {
            if (isset($data['results'])) {
                foreach ($data['results'] as $result) {
                    $response['places'][] = $result['formatted_address'];
                }
            }
        }

        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Wrapper for parseResponse
     * @return string
     */
    public function getParsedResponse()
    {
        if (isset($this->responseBody)) {
            return $this->parseResponse();
        }

        return json_encode(array('places' => array()));
    }

}
