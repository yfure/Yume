<?php

namespace Yume\Fure\AoE\ITraits\Iterator;

/*
 * Iterator
 *
 * @package Yume\Fure\AoE\ITraits\Iterator
 */
trait Iterator
{
    /*
     * Current element value.
     *
     * @values Int
     */
    protected Int $index = 0;
    
    use \Yume\Fure\AoE\ITraits\Overloader\Overload;
    
    /*
     * Return the current element.
     *
     * @access Public
     *
     * @return Mixed
     */
    public function current(): Mixed
    {
        return( $this->data[$this->index] );
    }
    
    /*
     * Rewind the Iterator to the first element.
     *
     * @access Public
     *
     * @return Void
     */
    public function rewind(): Void
    {
        $this->index = 0;
    }
    
    /*
     * Checks if current position is valid.
     *
     * @access Public
     *
     * @return Bool
     */
    public function valid(): Bool
    {
        return( isset( $this->data[$this->index] ) );
    }
    
    /*
     * Get value element.
     *
     * @access Public
     *
     * @return Mixed
     */
    public function value(): Mixed
    {
        return( $this->data[$this->index] );
    }
    
    /*
     * Move forward to next element.
     *
     * @access Public
     *
     * @return Void
     */
    public function next(): Void
    {
        $this->index++;
    }
    
    /*
     * Return the key of the current element.
     *
     * @access Public
     *
     * @return Mixed
     */
    public function key(): Mixed
    {
        return( $this->index );
    }
}

?>