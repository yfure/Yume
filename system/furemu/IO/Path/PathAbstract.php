<?php

namespace Yume\Kama\Obi\IO\Path;

/*
 * Directory
 *
 * @package Yume\Kama\Obi\IO
 */
abstract class PathAbstract
{
    
    /*
     * Tells whether the filename is a directory.
     *
     * @access Public Static
     *
     * @params String $dir
     *
     * @return Bool
     */
    public static function exists( String $dir ): Bool
    {
        return( is_dir( path( $dir ) ) );
    }
    
}

?>