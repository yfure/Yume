<?php

namespace App\HTTP\Controllers
{
    
    
    use function Yume\Func\view;
    
    use Yume\Kama\Obi\AoE;
    use Yume\Kama\Obi\HTTP;
    use Yume\Kama\Obi\Storage;
    
    class Profile extends HTTP\Controller
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
        
        public function main( String $user ): Void
        {
            echo view( "views.profile", new AoE\Data([
                'user' => $user,
                'name' => function() use( $user ) {
                    return( ucfirst( $user ) );
                },
                'title' => function() use( $user ) {
                    return( "$user (" . ucfirst( $user ) . ") · Octancle" );
                }
            ]));
        }
        
    }
    
}
    
?>