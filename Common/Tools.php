<?php

namespace Amarkal\Common;

class Tools
{
    /**
     * String to slug.
     * 
     * Generate a slug from a string by converting all the special characters
     * into dashes.
     * 
     * @param string $str The string to convert.
     * @return string The resulting slug.
     */
    static function strtoslug( $str )
    {
        return preg_replace( '/[^a-zA-Z0-9]+/s', '_', strtolower( $str ) );
    }
    
    /**
     * Check if the given array is associative, or sequential.
     * 
     * @param array $array The array to check
     * @return bool True if the given array is associative.
     */
    static function is_assoc( array $array ) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

}