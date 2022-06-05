<?php

namespace Yume\Kama\Obi\AoE\Buffer;

trait Overloader
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
    
    /*
     * Reset data saved.
     *
     * @access Public
     *
     * @return Void
     */
    public function __reset( String | Int $name = 0, Mixed $value = Null ): Void
    {
        $this->data = [];
        
        if( $value !== Null )
        {
            $this->data[$name] = $value;
        }
        
    }
    
}

?>