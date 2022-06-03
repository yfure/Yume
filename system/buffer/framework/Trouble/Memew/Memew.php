<?php

namespace Yume\Kama\Obi\Trouble\Memew;

use Throwable;

/*
 * Memew
 *
 * Sutakku is the class used to display uncaught exception trace messages,
 * this way you won't be in trouble when you encounter an uncaught exception.
 *
 * @package Yume\Kama\Obi\Trouble\Memew
 */
abstract class Memew
{
    
    /*
     * Handle uncaught exception.
     *
     * @access Public: Static
     *
     * @params Throwable $caught
     *
     * @return Void
     */
    public static function handler( Throwable $throw ): Void
    {
        $object = $throw;
        
        if( $object->getPrevious() !== Null )
        {
            $object = [ $object ];
            
            while( $throw = $throw->getPrevious() )
            {
                $object[( $throw::class )] = $throw;
            }
        }
        echo "<pre>" . json_encode( (new Sutakku\Sutakku( $object ))->stacks, JSON_PRETTY_PRINT );
    }
    
}

?>