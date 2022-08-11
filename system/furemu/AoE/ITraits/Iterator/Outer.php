<?php

namespace Yume\Fure\AoE\ITraits\Iterator;

/*
 * Outer
 *
 * @package Yume\Fure\AoE\ITraits\Iterator
 */
trait Outer
{
    use Iterator;
    
    /*
     * Returns the inner iterator for the current entry.
     *
     * @access Public
     *
     * @return Iterator
     */
    public function getInnerIterator(): ? \Iterator
    {
        // ....
    }
}

?>