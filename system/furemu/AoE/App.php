<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\Services;

use DateTimeZone;
use DateTime;

use ReflectionClass;

/*
 * App
 *
 * @package Yume\Kama\Obi\AoE
 */
class App
{
    
    use Buffer\Config;
    
    /*
     * ONSaved Instances
     *
     * @access Public Static
     *
     * @values Yume\Kama\Obi\Data
     */
    public Data $object;
    
    public function __construct()
    {
        
        $this->object = new Data([
            
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
    
    /*
     * Run the entire service class.
     *
     * @access Public
     *
     * @return Void
     */
    public function service(): Void
    {
        // Mapping all services.
        array_map( array: self::config( "services" ), callback: function( String $service )
        {
            // Create new class reflection.
            $reflect = new ReflectionClass( $service );
            
            // If the service class implements the Service Interface.
            if( $reflect->implementsInterface( Services\ServicesInterface::class ) )
            {
                // Run application boostrap.
                return( $reflect->getMethod( "boot" )->invoke( new $service, "boot" ) );
            }
            throw new Services\ServicesError( $service, Services\ServicesError::NOT_IMPLEMENTED );
        });
    }
    
}

?>