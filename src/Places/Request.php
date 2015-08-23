<?php
/**
 * Parses the global $_GET for parameters
 *
 * @package Places
 * @author Paul Grattan
 */

namespace PlaceFinder\Places;

class Request
{
    private $query;
    private $autoComplete;

    /**
     * Set the find parameter from the $query passed
     * @param string $query
     * @param boolean $autoComplete the type of request to make to google API
     */
    public function setFindQuery($query, $autoComplete = false)
    {
        $this->query = Sanitize::clean($query);
        $this->autoComplete = $autoComplete;
    }

    /**
     * Output the reponse to the browser
     */
    public function respond()
    {
        if (isset($this->query)) {
            
            $response = new MapsApiWrapper($this);
            
            $response->callPlacesApi();
            $response->output($response->getParsedResponse());
        }
    }

    public function getAutoComplete()
    {
        return $this->autoComplete;
    }
    
    public function getFindQuery()
    {
        return $this->query;
    }
}
