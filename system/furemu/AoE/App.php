<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\Environment;
use Yume\Kama\Obi\IO;
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
    
    /*
     * Construct method of class App.
     *
     * @access Public Instance
     *
     * @return Void
     */
    public function __construct()
    {
        
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
        
        // Load environment variables.
        Environment\Environment::onload();
        
        // Global object instance classes.
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
        // Get composer installed packages.
        $packages = IO\File::read( "vendor/composer/installed.json" );
        
        // Decode packages installed.
        $packages = json_decode( $packages, True );
        
        // Mapping all packages.
        array_map( array: $packages['packages'], callback: function( $package )
        {
            if( isset( $package['autoload']['psr-4'] ) )
            {
                Package::$packages = [
                    ...Package::$packages,
                    ...array_keys( $package['autoload']['psr-4'] )
                ];
            }
        });
        
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