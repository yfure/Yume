<?php

namespace Yume\Fure\HTTP\Session;

use Yume\Fure\AoE;
use Yume\Fure\Seclib;

/*
 * SessionSecure
 *
 * @package Yume\Fure\HTTP\Session
 */
abstract class SessionSecure
{
    
    /*
     * Encode session value.
     *
     * @access Public Static
     *
     * @params String $data
     *
     * @return String
     */
    public static function encode( String $data ): String
    {
        return( Seclib\Simple\AES::encode( $data ) );
    }
    
    /*
     * Encode session value.
     *
     * @access Public Static
     *
     * @params String $edata
     *
     * @return String
     */
    public static function decode( String $edata ): String
    {
        // ....
    }
    
    
}

?>