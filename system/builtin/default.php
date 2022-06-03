<?php

namespace Yume\Yume\Funcs;

class Func
{
    protected static $init;
    
    public static function init(): Void
    {
        if( self::$init === Null ) {
            self::$init = True;
            
            // Import all functions in this directory.
            $scan = scandir( __DIR__ );
            
            foreach( $scan As $file ) {
                if( substr( $file, 0, -4 ) !== "default" ) {
                    if( substr( $file, -4 ) === ".php" ) {
                        require $file;
                    }
                }
            }
        }
    }
    
    public static function path( ?String $subject = Null ): String
    {
        return BASE_PATH . $subject;
    }
    
    public static function appPath( ?String $subject = Null ): String
    {
        return self::path( "/apps/{$subject}" );
    }
    
    public static function config( String $config ): Mixed
    {
        if( file_exists( $file = self::configPath( strtolower( $config ) . ( substr( $config, -4 ) !== ".php"? ".php" : "" ) ) ) ) {
            
            // Return value from config file.
            return require( $file );
        }
        return False;
    }
    
    public static function configPath( ?String $subject = Null ): String
    {
        return self::path( "/configs/{$subject}" );
    }
    
    public static function flooping( Array $array, Callable $callback, Bool $stop = False )
    {
        if( count( $array ) !== 0 ) {
            foreach( $array As $key => $value ) {
                
                // Calling the callback function.
                $endl = call_user_func_array( $callback, [ $key, $value ] );
                
                // Stop looping if callback return <True>
                if( $stop && $endl !== False && $endl !== Null ) {
                    
                    return True;
                }
            }
        }
    }
    
    public static function ls( String $dir ): Array | Null
    {
        if( is_dir( self::path( $dir ) ) )
        {
            return( array_diff( scandir( self::path( $dir ) ), [ ".", ".." ] ) );
        }
        return Null;
    }
    
    public static function resource( String $resource ): Mixed
    {
        // ....
        $substr = substr( $resource, -4 );
        
        if( $substr === ".php" ) {
            if( file_exists( $f = self::resourcePath( $resource ) ) ) {
                
                // Return given value from resource.
                return( require( $f ) );
            }
        } else {
            
            // Pattern for deleting comments that are in a resource.
            $pattern = "/#![-|.|y]\s[^\n]+\n*|\/\!.*?!\//s";
            
            // If resource file is not css/js file.
            if( $substr !== ".css" ) {
                if( substr( $resource, -3 ) !== ".js" ) {
                    
                    // Add <.yume> extension if resource name doesn't have extension.
                    $resource .= substr( $resource, -5 ) !== ".yume"? ".yume" : "";
                }
            }
            
            // Check if the resource exists or not.
            if( file_exists( $f = self::resourcePath( $resource ) ) ) {
                
                return preg_replace( $pattern, "", file_get_contents( $f ) );
            }
        }
        return False;
    }
    
    public static function resourcePath( String $file ): String
    {
        return self::path( "/resource/{$file}" );
    }
    
    public static function resourceReplace( String $subject, ?Callable $callback = Null ): String
    {
        // ..
        if( $callback === Null ) {
            $callback = function( $m ) {
                
                // Get resource value or resource file path.
                return( $m[1] === "*"? resourcePath( $m[2] ) : ( ( $r = resource( $m[2] ) ) !== False? $r : "" ) );
            };
        }
        
        // Pattern to replace string with resource.
        $pattern = "/re([\*]*){\s*([^\s*}]+)\s*}/";
        
        // Replace string according to pattern with resource value.
        return preg_replace_callback( pattern: $pattern, subject: $subject, callback: $callback );
    }
    
    public static function storagePath( ?String $subject = Null ): String
    {
        return self::path( "/storage/{$subject}" );
    }
    
    public static function tree( String $path, Bool $file = True ): Array
    {
        $result = [];
        
        // Remove Last Slash.
        $path = $path !== "/"? ( substr( $path, -1 ) !== "/"? $path : substr( $path, 0, -1 ) ) : "/";
        
        // List Value.
        $ls = self::ls( $path );
        
        if( $ls !== Null ) {
            if( count( $ls ) !== 0 ) {
                foreach( $ls As $fileOrDir ) {
                    if( is_dir( self::path( $dir = "{$path}/{$fileOrDir}" ) ) ) {
                        if( count( $loop = self::tree( $dir, $file ) ) !== 0 ) {
                            $result[$fileOrDir] = $loop;
                        } else {
                            $result[] = $fileOrDir;
                        }
                    } else {
                        if( $file ) {
                            $result[] = $fileOrDir;
                        }
                    }
                }
            }
        }
        
        return( $result );
    }
}

?>