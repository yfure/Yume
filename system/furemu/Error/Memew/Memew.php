<?php

namespace Yume\Fure\Error\Memew;

use Yume\Fure\AoE;
use Yume\Fure\HTTP;

use Throwable;

/*
 * Memew
 *
 * Memew is the class used to display uncaught exception trace messages,
 * this way you won't be in trouble when you encounter an uncaught exception.
 *
 * @package Yume\Fure\Error\Memew
 */
abstract class Memew
{
    
    /*
     * Handle all uncaught exceptions.
     *
     * @access Public Static
     *
     * @params Throwable $throw
     *
     * @return Void
     */
    public static function handler( Throwable $throw ): Void
    {
        // ....
        $stack = $throw;
        
        // If exception thrown has previous.
        if( $stack->getPrevious() !== Null )
        {
            // Exception class previous.
            $stack = [ $stack ];
            
            // Main exception class thrown.
            $prevs = $throw;
            
            while( $prevs = $prevs->getPrevious() )
            {
                // Insert previous class.
                $stack[$prevs::class] = $prevs;
            }
        }
        
        // Create new Sutakku claass instance.
        $sutakku = new Sutakku\Sutakku( $stack );
        
        // Display exception output.
        echo f( "<pre>\n{}\n{}", [
            $throw::class, 
            htmlspecialchars( AoE\Tree::tree([ Throwable::class => $sutakku->getStacks() ]) )
        ]);
    }
    
}

?>