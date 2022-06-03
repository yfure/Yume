<?php

namespace App\Package;

use App\Models\User;

use Yume\Kama\Obi\{
    Cache,
    Database,
    Http,
    Storage
};

class UserAuthentication
{
    
    public static $logging;
    public static $cache;
    
    public static function signin( HTTP\RequestInterface $req )
    {
        
    }
    
    public static function signup( HTTP\RequestInterface $req )
    {
        
    }
    
    public static function logout( HTTP\RequestInterface $req )
    {
        
    }
    
    public static function window()
    {
        if( HTTP\Session\Session::get( "user.logging" ) ) {
            
        } else {
            
            // Get Active Cookie.
            $cookie = HTTP\Cookie\Cookie::item( "user.logging" );
            
            // Check if the cookie is still active or not.
            if( $cookie->isset() ) {
                
                //
            } else {
                
                return False;
            }
        }
    }
    
}

?>