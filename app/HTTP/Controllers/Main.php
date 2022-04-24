<?php

namespace App\HTTP\Controllers
{
    
    use Yume\Util\HTTP;
    
    /*
     * Main class application.
     *
     * @package App\HTTP\Controllers
     */
    class Main extends HTTP\Controller
    {
        /*
         * Main class constructor.
         * 
         * @access Public
         * 
         * @return Static
         */
        public function __construct()
        {
            HTTP\Session\Session::start();
        }
        
        /*
         * Controller main method.
         *
         * @access Public
         *
         * @return Mixed
         */
        public function main()
        {
            return( $this->view( "main" ) );
        }
        
    }
    
}
    
?>
