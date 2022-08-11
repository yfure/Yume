<?php

namespace Yume\Fure\HTTP\Session;

use Yume\Fure\AoE;
use Yume\Fure\HTTP;
use Yume\Fure\Threader;

abstract class Session
{
    
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
            $configs = Threader\App::config( "http.session.configs" );
            
            // Get session save handler class.
            $handler = Threader\App::config( "http.session.handler" );
            
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
    
    /*
     * Get session value.
     *
     * @access Public Static
     *
     * @params String $name
     *
     * @return String|Bool
     */
    public static function get( String $name ): Bool | String
    {
        if( self::isset( $name ) )
        {
            return( SessionSecure::decode( $_SESSION[$name] ) );
        }
        return( False );
    }
    
    /*
     * Set and update session values.
     *
     * @access Public Static
     *
     * @params String $name
     * @params String $value
     *
     * @return String|Bool
     */
    public static function set( String $name, String $value ): Bool | String
    {
        if( isset( $_SESSION ) )
        {
            return( $_SESSION[$name] = SessionSecure::encode( $value ) );
        }
        return( False );
    }
    
    /*
     * Check if the session is set.
     *
     * @access Public Static
     *
     * @params String $name
     *
     * @return Bool
     */
    public static function isset( String $name ): Bool
    {
        if( isset( $_SESSION ) )
        {
            return( isset( $_SESSION[$name] ) );
        }
        return( False );
    }
    
    /*
     * Unset session.
     *
     * @access Public Static
     *
     * @params String $name
     *
     * @return Void
     */
    public static function unset( String $name ): Void
    {
        if( isset( $_SESSION ) )
        {
            unset( $_SESSION[$name] );
        }
    }
    
    /*
     * Destroy the current session.
     *
     * @access Public Static
     *
     * @return Void
     */
    public static function destroy(): Void
    {
        $_SESSION = [];
        
        // Unset all of the session variables.
        unset( $_SESSION );
        
        if( Threader\App::config( "http.session.configs[session.use_cookies]" ) )
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