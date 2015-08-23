<?php
/**
 * Transformer for JSON
 *
 * @package Places
 * @author Paul Grattan
 */

namespace PlaceFinder\Places;

class Transform
{
    
    public static function jsonToArray($string)
    {
        $array = json_decode($string, true);
        
        if ((json_last_error() !== JSON_ERROR_NONE)) {
            // Log an error json_last_error();
            // return an empty array
            return array();
        }

        return $array;
    }

}
