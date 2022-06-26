<?php

namespace Yume\Kama\Obi\AoE;

use DateTimeZone;
use DateTime;

final class App
{
    
    /*
     * ONSaved Instances
     *
     * @access Public Static
     *
     * @values Yume\Kama\Obi\Data
     */
    public static $object;
    
    use Buffer\Config;
    
    /*
     * Initialize app runtime.
     *
     * @access Public, Static
     *
     * @return Void
     */
    public static function buff(): Void
    {
        
        /*
         * DateTimeZone
         *
         * Create a new instance of the DateTimeZone class,
         * parameter values based on the application configuration.
         *
         * @see configs/app
         */
        $dateTimeZone = new DateTimeZone( self::config( "timezone" ) );
        
        /*
         * DateTime
         *
         * Set datetime by current timezone.
         */
        $dateTime = new DateTime( "now", $dateTimeZone );
        
        self::$object = new Data([
            "dateTimeZone" => $dateTimeZone,
            "dateTime" => $dateTime
        ]);
        
        /*
         * Set user-defined error handler function.
         *
         * @see configs/app.trouble.error.handler
         */
        set_error_handler( self::config( "trouble.error.handler" ) );
        
        /*
         * Sets a user-defined exception handler function.
         *
         * @see configs/app.trouble.exception.handler
         */
        set_exception_handler( self::config( "trouble.exception.handler" ) );
        
        ini_set( "session.save_handler", "files" );
        
        /*
         * Sets user-level session storage functions.
         *
         * @see configs/app.http.session.handler
         */
        session_set_save_handler( new (self::config( "http.session.handler" )), True );
        
    }
    
}

?>