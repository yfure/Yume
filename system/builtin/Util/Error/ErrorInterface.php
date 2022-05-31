<?php

namespace Yume\Util\Error;

interface ErrorInterface
{
    
    /*
     * Write error info.
     *
     * @access Public, Static
     *
     * @params String <dir>
     *
     * @return Void
     */
    public static function write( String $dir, Array $error ): Void;
    
}

?>
