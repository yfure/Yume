<?php

namespace App\HTTP\Controllers;

use Yume\Kama\Obi\{
    Exception,
    Http,
    Hedda,
    Loader,
    Reflection,
    Session,
    Tree
};

/*
 * Example controller class.
 *
 * @extends Yume\Kama\Obi\HTTP\Controller
 */
class Welcome extends HTTP\Controller
{
    /*
     * Instantiate a new controller instance.
     *
     * @return Static
     */
    public function __construct()
    {
        // Something....
    }
    
    /*
     * Main method to be executed.
     *
     * @access Public
     *
     * @return Void
     */
    public function main(): Void
    {
        // Something....
        echo "Welcome To Yume";
    }

    /*
     * An example of how we can display a stack
     * Trace against an exception class.
     * 
     * @access Public
     * 
     * @return Void
     */
    public function stackTrace(): Void
    {
        try {
            try {
                try {
                    throw new \AssertionError( "Assertion" );
                } catch( \Trouble $e ) {
                    throw new \ArithmeticError( "Arithmetic", 0, $e );
                }
            } catch( \Trouble $e ) {
                throw new \RuntimeException( "Runtime", 0, $e );
            }
        } catch( \Trouble $e ) {
            printStackTrace( $e );
        }
    }

    /*
     * An example of how we can display all loaded Yume classes.
     * 
     * @access Public
     * 
     * @return Void
     */
    public function classDump(): Void
    {
        Loader\Loader::dump();
    }
    
}

?>