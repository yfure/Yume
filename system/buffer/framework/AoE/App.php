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
         * @access Public, Static
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
            
            // Get app configuration.
            self::$configs = config( "app" );
            
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
            
            set_error_handler( "Yume\Kama\Obi\Trouble\Toriga\Toriga::handler" );
            //set_exception_handler( "Yume\Kama\Obi\Trouble\Sutakku\Sutakku::handler" );
            set_exception_handler( "Yume\Kama\Obi\Trouble\Memew\Memew::handler" );
            
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