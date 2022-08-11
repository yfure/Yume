<?php

namespace Yume\Fure\Threader;

use Yume\Fure\AoE;
use Yume\Fure\Environment;
use Yume\Fure\Error;
use Yume\Fure\IO;
use Yume\Fure\Services;

use DateTimeZone;
use DateTime;

use ReflectionClass;

/*
 * App
 *
 * @package Yume\Fure\Threader
 */
final class App implements AoE\Intafesu\Unchangeable
{
    use \Yume\Fure\AoE\ITraits\Config;
    
    /*
     * ONSaved Instances
     *
     * @access Public Static
     *
     * @values Yume\Fure\Data
     */
    public AoE\Data $object;
    
    /*
     * Create new application.
     *
     * @access Public Static
     *
     * @return Static
     */
    public static function create(): Static
    {
        if( Runtime::$app Instanceof App )
        {
            throw new Error\RuntimeError( "Application initialization found, application cannot be duplicated." );
        }
        return( new Self );
    }
    
    /*
     * Construct method of class App.
     *
     * @access Private Instance
     *
     * @return Void
     */
    private function __construct()
    {
        // Global object instance classes.
        $this->object = new AoE\Data([
            
            /*
             * DateTimeZone
             *
             * Create a new instance of the DateTimeZone class,
             * parameter values based on the application configuration.
             */
            "dateTimeZone" => $dateTimeZone = new DateTimeZone( self::config( "localization.timezone" ) ),
            
            /*
             * DateTime
             *
             * Set datetime by current timezone.
             */
            "dateTime" => $dateTime = new DateTime( "now", $dateTimeZone )
            
        ]);
        
        // Load environment variables.
        Environment\Environment::onload();
        
        // Mapping application configs.
        self::$configs = Environment\Environment::mapping( self::config() );
        
        $this->setup();
        $this->service();
    }
    
    /*
     * Setup application.
     *
     * @access Protected
     *
     * @return Void
     */
    protected function setup(): Void
    {
        /*
         * Sets the default timezone used by all date/time functions in a script.
         *
         * @ses configs/app.localization.timezone.
         */
        date_default_timezone_set( self::config( "localization.timezone" ) );
        
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
     * @access Protected
     *
     * @return Void
     */
    protected function service(): Void
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
                AoE\Package::$packages = [
                    ...AoE\Package::$packages,
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