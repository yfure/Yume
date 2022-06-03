<?php

/*
 * Super global constants.
 *
 * @author hxAri
 * @license Under MIT
 */
return( $constant = [
    
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
        'VENDOR_PATH' => "/vendor",
        'CONFIG_PATH' => "/configs",
        'SYSTEM_PATH' => "/system",
        'FUNC_PATH' => "/system/helper",
        'ROUTES_PATH' => "/storage/routes",
        'UTIL_PATH' => "/system/builtin/Util",
        'STORAGE_PATH' => "/storage",
        'DATABASE_PATH' => "/storage/database",
        'EREMENTO_PATH' => "/storage/eremento",
        'LANGUAGE_PATH' => "/storage/language",
        'NOTEWARE_PATH' => "/storage/noteware",
        'RESOURCE_PATH' => "/storage/resource",
        
        /*
         * Application environment.
         *
         * @values String
         */
        'ENVIRONMENT' => "development"
        
    ],
    
    'SERVER' => $_SERVER
    
]);

?>