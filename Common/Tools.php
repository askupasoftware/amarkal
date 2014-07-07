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
        return preg_replace( '/[ .\-_@#$%^&*();\\/|<>"\'!+]+/', '-', strtolower( $str ) );
    }
}