<?php

namespace Yume\Func;

/*
 * Get path name.
 *
 * @params String, Null <app>
 * @params String, Null <base>
 * @params String, Null <util>
 * @params String, Null <config>
 * @params String, Null <routes>
 * @params String, Null <storage>
 * @params String, Null <resource>
 * @params String, Null <noteware>
 *
 * @return String
 */
function path( ? String $app = Null, ? String $base = Null, ? String $util = Null, ? String $config = Null, ? String $routes = Null, ? String $storage = Null, ? String $asset = Null, ? String $log = Null ): String
{
    $path = BASE_PATH;
    
    $paths = [
        'app' => "/app",
        'base'=> "",
        'config'=> "/configs",
        'routes' => "/system/routes",
        'util' => "/system/builtin/Util",
        'storage'=> "/storage",
        'asset' => "/assets",
        'log' => "/storage/logs"
    ];
    
    foreach( $paths As $i => $v )
    {
        if( ${ $i } !== Null )
        {
            return( pathReplaceSeparator( $path . $v . ${ $i } ) );
        }
    }
    
    return( pathReplaceSeparator( $path ) );
}

/*
 * Replace directory separator.
 *
 * @params String <path>
 *
 * @return String
 */
function pathReplaceSeparator( String $path ): String
{
    return( preg_replace( "/\//", DIRECTORY_SEPARATOR, $path ) );
}

?>