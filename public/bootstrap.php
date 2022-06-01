<?php

/*
 * Bootstrap
 *
 * Bootstrapping for the framework.
 *
 */
if( version_compare( PHP_VERSION, "8.0.6" ) > 0 )
{
    
    /*
     * Application constants.
     *
     * @values Array
     */
    $constants = [
        
        /*
         * Runtime application.
         *
         * @values Bool
         */
        'CLI' => php_sapi_name() === "cli",
        
        /*
         * Dynamically base url.
         *
         * @values Callable
         *
         * @return String
         */
        'BASE_URL' => function() {
            
            // Default base url.
            $baseURL = "http";
            
            if( isset( $_SERVER['HTTP_HOST'] ) )
            {
                if( isset( $_SERVER['HTTPS'] ) )
                {
                    if( strtolower( $_SERVER['HTTPS'] ) == "on" )
                    {
                        $baseURL = "https";
                    }
                }
                
                // Get url webpage.
                $baseURL .= "://{$_SERVER['HTTP_HOST']}";
                
                // Replacimg script name.
                $baseURL .= str_replace( basename( $_SERVER['SCRIPT_NAME'] ), "", $_SERVER['SCRIPT_NAME'] );
            } else {
                
                // This will only happen if through the terminal.
                $baseURL = "";
            }
            return( $baseURL );
        },
        
        /*
         * Document root application.
         *
         * @values Callable
         *
         * @return String
         */
        'BASE_ROOT' => function() {
            
            // The core of a hierarchically structured file system.
            // Get document path root server.
            $baseRoot = $_SERVER['DOCUMENT_ROOT'];
            
            // This will probably only apply to android
            // Users who run this via the "KSWEB" or "Termux" software.
            $baseRoot = preg_replace( "/\/mnt\/sdcard\/|\/sdcard\//", "/storage/emulated/0/", CLI ? str_replace( "/public", "", __DIR__ ) : $baseRoot );
            
            return( $baseRoot );
        },
        
        /*
         * Base application path.
         *
         * @values Callable
         *
         * @return String
         */
        'BASE_PATH' => fn() => preg_replace( "/[\/|\\\](public|bootstrap)/i", "", BASE_ROOT ),
        
    ];
    
    foreach( $constants as $name => $value )
    {
        if( defined( $name ) === False )
        {
            define( $name, is_callable( $value ) ? $value() : $value );
        }
    }
    
    /*
     * Set PHP Error handler
     *
     * @object Yume\Kama\Obi\Error\Error
     * @method handler
     */
    set_error_handler( "Yume\Kama\Obi\Error\Error::handler" );
    
    /*
     * Set PHP Exception handler
     *
     * @object Yume\Kama\Obi\Exception\Exception
     * @method handler
     */
    set_exception_handler( "Yume\Kama\Obi\Exception\Exception::handler" );
    
} else {
    throw new UnexpectedValueException( "PHP version not supported by framework." );
}

?>