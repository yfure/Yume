<?php

namespace Yume\Kama\Obi\Trouble\Memew;

use Yume\Kama\Obi\AoE;

use Throwable;

/*
 * Memew
 *
 * Memew is the class used to display uncaught exception trace messages,
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
        
        $sutakku = new Sutakku\Sutakku( $object );
        $sutakku = AoE\Tree::tree([ Throwable::class => $sutakku->stacks ], 0, AoE\Tree::POINT );
        
        echo "<pre>" . $sutakku;
        
    }
    
}

?>