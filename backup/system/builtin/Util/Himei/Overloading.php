<?php

namespace Yume\Kama\Obi\AoE;

trait Overloading
{
    use Overload;
    
    /*
     * Set new data.
     *
     * @access Public
     *
     * @params String <name>
     * @params Mixed <value>
     *
     * @return Void
     */
    public function __set( String $name, Mixed $value ): Void
    {
        $this->data[$name] = $value;
    }
    
    /*
     * Get hidden data.
     *
     * @access Public
     *
     * @params String <name>
     *
     * @return Mixed
     */
    public function __get( String $name ): Mixed
    {
        return( $this->__isset( $name ) ? $this->data[$name] : False );
    }
    
    /*
     * Is data set.
     *
     * @access Public
     *
     * @params String <name>
     *
     * @return Bool
     */
    public function __isset( String $name ): Bool
    {
        return( isset( $this->data[$name] ) );
    }
    
    /*
     * Unset hidden data.
     *
     * @access Public
     *
     * @params String <name>
     *
     * @return Void
     */
    public function __unset( String $name ): Void
    {
        unset( $this->data[$name] );
    }
    
}

?>