<?php

namespace Yume\Kama\Obi\AoE
{
    
    use function Yume\Func\config;
    use function Yume\Func\path;
    
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
        
        use Config;
        
        /*
         * Initialize app runtime.
         *
         * @access Public, Static
         *
         * @return Void
         */
        public static function init(): Void
        {
            
            // Get app configuration.
            self::$config = config( "app" );
            
            // Create instance.
            self::$object = new Data;
            
            /*
             * DateTime
             * DateTimeZone
             *
             * Set time format based on configuration or
             * You can change it in application configuration section.
             */
            self::$object->dateTime = new DateTime( "now", self::$object->dateTimeZone = new DateTimeZone( self::config( "locale.timezone" ) ) );
            
            /** Set Error Handler function. */
            set_error_handler( self::config( "error.handler.trigger" ) );
            set_exception_handler( self::config( "error.handler.exception" ) );
            
            //throw new \Exception;
            
        }
    }
    
}

?>