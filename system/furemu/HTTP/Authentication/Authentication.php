<?php

namespace Yume\Fure\HTTP\Authentication;

/*
 * Authentication
 *
 * @package Yume\Fure\HTTP\Authentication
 */
abstract class Authentication
{
    
    public static function auth( String $username, String $password )
    {
        
    }
    
    public static function isAuth(): Bool
    {
        return( False );
    }
    
}

?>