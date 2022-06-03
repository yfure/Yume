<?php

namespace App\HTTP\Controllers
{
    
    use function Yume\Func\view;
    
    use App\Models;
    use App\Package\UserAuthentication As User;
    
    use Yume\Kama\Obi\Hedda;
    use Yume\Kama\Obi\HTTP;
    use Yume\Kama\Obi\Storage;
    
    class Home extends HTTP\Controller
    {
        /*
         * Starting new session.
         * 
         * @access Public
         * 
         * @return Static
         */
        public function __construct()
        {
            HTTP\Session\Session::start();
        }
        
        public function main(): Void
        {
            if( User::window() )
            {
                echo 7;
            } else {
                
                echo( view( "views.home" ) );
            }
        }
        
    }
    
}

?>