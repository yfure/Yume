<?php

namespace Yume\Kama\App\HTTP\Controllers;

use Yume\Kama\App\Models;

use Yume\Kama\Obi\HTTP;

/*
 * User Controller
 *
 * @package Yume\Kama\App\HTTP\Controllers
 */
class User extends HTTP\Controller\Controller
{
    
    /*
     * Construct method of class User Controller.
     *
     * @access Public Instance
     *
     * @return Void
     */
    public function __construct()
    {
        // ....
    }
    
    /*
     * Main method of controller.
     *
     * @access Public
     *
     * @params String $user
     * @params String $tabs
     *
     * @return Void
     */
    public function main( String $user )//: Void
    {
        return( f( "Hi {}, welcome to the board!", $user ) );
    }
    
}

?>