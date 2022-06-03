<?php

/*
 * Bootrapping file for Yume Framework.
 *
 * Takes various functions as well as built-in classes from yume.
 * It will also check if the user is using php version ^8.0.
 *
 * @author hxAri
 * @license Under MIT
 */
try {
    if( PHP_VERSION < $v = "8.0.6" )
    {
        throw new RuntimeException( "Oops sorry it looks like you are using a PHP version\nbelow {$v} please upgrade the PHP version to {$v} or higher." );
    }
} catch( RuntimeException $e ) {
    echo $e::class . ": {$e->getMessage()}\n{$e->getFile()} on line {$e->getLine()}";
}

$constant = [
    
    'YUME' => [
        
        /*
         * Runtime application.
         *
         * @values Bool
         */
        'isCommandLineInterface' => php_sapi_name() === "cli",
        
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
            
            if( isset( $_SERVER['HTTP_HOST'] ) ) {
                if( isset( $_SERVER['HTTPS'] ) ) {
                    if( strtolower( $_SERVER['HTTPS'] ) == 'on' ) {
                        $baseURL = "https";
                    }
                }
                
                // Get url webpage.
                $baseURL .= '://'. $_SERVER['HTTP_HOST'];
                
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
            
            if( isCommandLineInterface )
            {
                $baseRoot = str_replace( "/system/__init__", "", __DIR__ );
            }
            
            // This will probably only apply to android
            // Users who run this via the "KSWEB" or "Termux" software.
            $baseRoot = preg_replace( "/\/mnt\/sdcard\/|\/sdcard\//", "/storage/emulated/0/", $baseRoot );
            
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
        
        /*
         * Application path.
         *
         * @values Callable
         *
         * @return String
         */
        'APP_PATH' => "/app",
        'ASSETS_PATH' => "/assets",
        'VENDOR_PATH' => "/vendor",
        'CONFIG_PATH' => "/configs",
        'SYSTEM_PATH' => "/system",
        'FUNC_PATH' => "/system/helper",
        'ROUTES_PATH' => "/storage/routes",
        'UTIL_PATH' => "/system/builtin/Util",
        'STORAGE_PATH' => "/storage",
        'LOG_PATH' => "/storage/logs",
        'DATABASE_PATH' => "/storage/database",
        'LANGUAGE_PATH' => "/storage/language",
        
        /*
         * Application environment.
         *
         * @values String
         */
        'ENVIRONMENT' => "development"
        
    ],
    
    'SERVER' => $_SERVER
    
];

/*
 * Define super global constants based element name.
 *
 * You can also implement your constant names and values easily.
 * See ./const file for define new constant.
 */
foreach( $constant As $group => $array )
{
    foreach( $array As $const => $value )
    {
        define( ( $group === "SERVER" ? "SERVER_" : "" ) . $const, is_callable( $value ) ? call_user_func( $value ) : $value );
    }
}

?>