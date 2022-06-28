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
        
        self::$object = new Data([
            
            /*
             * DateTimeZone
             *
             * Create a new instance of the DateTimeZone class,
             * parameter values based on the application configuration.
             *
             * @see configs/app
             */
            "dateTimeZone" => $dateTimeZone = new DateTimeZone( self::config( "timezone" ) ),
            
            /*
             * DateTime
             *
             * Set datetime by current timezone.
             */
            "dateTime" => $dateTime = new DateTime( "now", $dateTimeZone )
            
        ]);
        
        /*
         * Sets the default timezone used by all date/time functions in a script.
         *
         * @ses configs/app.timezone.
         */
        date_default_timezone_set( self::config( "timezone" ) );
        
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
        
    }
    
}

?>