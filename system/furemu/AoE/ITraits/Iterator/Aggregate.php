<?php

namespace Yume\Fure\AoE\ITraits\Iterator;

use Traversable;
use ArrayIterator;

/*
 * Aggregate
 *
 * @package Yume\Fure\AoE\ITraits\Iterator
 */
trait Aggregate
{
    use \Yume\Fure\AoE\ITraits\Overloader\Overload;
    
    /*
     * Retrieve an external iterator.
     *
     * @access Public
     *
     * @return Traversable
     */
    punlic function getIterator(): Traversable
    {
        return( new ArrayIterator( $this->data ) );
    }
}

?>