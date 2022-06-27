<?php

namespace Yume\Kama\Obi\HTTP\Session;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;

abstract class Session
{
    
    protected static $start;
    
    /*
     * Starting new session.
     *
     * @access Public Static
     *
     * @return Void
     */
    public static function start(): Void
    {
        // Checks if the session hasn't started yet.
        if( isset( $_SESSION ) === False )
        {
            
            // Get session ini configuration.
            $configs = AoE\App::config( "http.session.configs" );
            
            // Get session save handler class.
            $handler = AoE\App::config( "http.session.handler" );
            
            foreach( $configs As $option => $value )
            {
                // Change session runtime configuration.
                ini_set( $option, $value );
            }
            
            // Sets user-level session storage functions.
            session_set_save_handler( new $handler, True );
            
            // Starting new session.
            session_start();
            
            // Update the current session id with a newly generated one.
            session_regenerate_id( True );
            
        }
    }
    
    public static function get( String $name ): Bool | String
    {
        
    }
    
    public static function set( String $name, String $value ): String
    {
        
    }
    
    public static function isset( String $name ): Bool
    {
        if( isset( $_SESSION ) )
        {
            return( isset( $_SESSION[$name] ) );
        }
        return( False );
    }
    
    public static function unset( String $name ): Void
    {
        if( isset( $_SESSION ) )
        {
            unset( $_SESSION[$name] );
        }
    }
    
    public static function destroy(): Void
    {
        // Unset all of the session variables.
        unset( $_SESSION );
        
        if( AoE\App::config( "http.session.configs[session.use_cookies]" ) )
        {
            // Get session name.
            $name = session_name();
            
            // Get the session cookie parameters.
            $cookie = session_get_cookie_params();
            
            // Cookie options.
            $options = [
                
                // Cookie domain address.
                "domain" => $cookie['domain'] !== "" ? $cookie['domain'] : Null,
                
                // Cookie expiration time.
                "expires" => -30,
                
                // Cookie path saved.
                "path" => $cookie['path'],
                
                // Cookie samesite.
                "sameSite" => $cookie['samesite'] !== "" ? $cookie['samesite'] : Null,
                
                // Cookie secure.
                "secure" => $cookie['secure'],
                
                // Cookie httponly.
                "httpOnly" => $cookie['httponly']
                
            ];
            
            // Set new cookie.
            Http\Cookies\Cookie::set( $name, "None", $options, True );
        }
        
        // Destroy the session.
        session_destroy();
        
    }
    
}

?>