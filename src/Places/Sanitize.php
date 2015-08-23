<?php
/**
 * Basic sanitizer for strings
 * 
 * @package Places
 * @author Paul Grattan
 */

namespace PlaceFinder\Places;

class Sanitize
{
    public static function clean($string)
    {
        return strip_tags($string);
    }

    public static function arrayKeysToLower($array)
    {
        return array_change_key_case($array, CASE_LOWER);
    }
}
