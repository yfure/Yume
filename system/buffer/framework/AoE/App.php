<?php

namespace Yume\Kama\Obi\AoE
{
    
    use DateTimeZone;
    use DateTime;
    
    abstract class App
    {
        
        /*
         * DateTime Class Instance.
         *
         * @access Public: Static
         *
         * @values DateTime
         */
        public static $dateTime;
        
        /*
         * DateTimeZone Class Instance.
         *
         * @access Public, Static
         *
         * @values DateTimeZone
         */
        public static $dateTimeZone;
        
        /*
         * Router Class Instance.
         *
         * @access Public, Static
         *
         * @values Yume\Kama\Obi\HTTP\Route\Router
         */
        public static $router;
        public static $object;
        
        use Traits\Config;
        
        /*
         * Initialize app runtime.
         *
         * @access Public, Static
         *
         * @return Void
         */
        public static function buff(): Void
        {
            
            // Create instance.
            self::$object = new Data;
            
            /*
             * DateTime
             * DateTimeZone
             *
             * Set time format based on configuration or
             * You can change it in application configuration section.
             */
            self::$object->dateTime = new DateTime( "now", self::$object->dateTimeZone = new DateTimeZone( self::config( "timezone" ) ) );
            
            /*
             * Set user-defined error handler function.
             *
             * @see configs/app
             */
            set_error_handler( self::config( "trouble.error.handler" ) );
            
            /*
             * Sets a user-defined exception handler function.
             *
             * @see configs/app
             */
            set_exception_handler( self::config( "trouble.exception.handler" ) );
            
            try {
                try {
                    try {
                        throw new \ArithmeticError( "Catch me!" );
                    } catch( \ArithmeticError $e ) {
                        throw new \AssertionError( "", 0, previous: $e );
                    }
                } catch( \AssertionError $e ) {
                    throw new \RuntimeException( "", 0, previous: $e );
                }
            } catch ( \RuntimeException $e ) {
                throw new \Error( "", 0, previous: $e );
            }
            
        }
        
        public static function x() {}
    }
    
}

?>