<?php

namespace Yume\Kama\Obi\AoE;

trait Iterator
{
    
    /*
     * Current element value.
     *
     * @values Int
     */
    protected $position;
    
    use Overload;
    
    /*
     * Return the current element.
     *
     * @access Public
     *
     * @return Mixed
     */
    public function current(): Mixed
    {
        return( $this->data[$this->position] );
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
        $this->position = 0;
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
        return( isset( $this->data[$this->position] ) );
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
        return( $this->data[$this->position] );
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
        $this->position++;
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
        return( $this->position );
    }
    
}

?>