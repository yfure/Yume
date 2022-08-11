<?php

namespace Yume\App\HTTP\Controllers;

use Yume\App\Models;

use Yume\Fure\HTTP;


/*
 * Main Controller
 *
 * @extends Yume\Fure\HTTP\Controller\Controller
 *
 * @package Yume\App\HTTP\Controllers
 */
class Main extends HTTP\Controller\Controller
{
    
    /*
     * Construct method of class Main Controller.
     *
     * @access Public Instance
     *
     * @return Void
     */
    public function __construct()
    {
        // ...
    }
    
    /*
     * Main method of Main controller.
     *
     * @access Public
     *
     * @return Void
     */
    public function main( HTTP\Routing\Route $route ): Void
    {
        echo "Welcome to Yume!";
    }
    
}

?>