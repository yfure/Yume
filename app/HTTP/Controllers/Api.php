<?php

namespace Yume\App\HTTP\Controllers;

use Yume\Fure\HTTP;

/*
 * Api Controller
 *
 * @extends Yume\Fure\HTTP\Controller\Controller
 *
 * @package Yume\App\HTTP\Controllers
 */
class Api extends HTTP\Controller\Controller
{
    
    /*
     * Construct method of class Api Controller.
     *
     * @access Public Instance
     *
     * @return Void
     */
    public function __construct()
    {
        // Set default response content type.
        HTTP\HTTP::header( "Content-Type: application/json;charset=utf8", True );
    }
    
    public function scheme(): Array
    {
        
    }
    
}

?>