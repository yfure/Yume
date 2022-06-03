<?php

namespace Yume\Kama\Obi\AoE;

// Register package.
class Tree
{
    
    const STRAIGHT = "│   ";
    const MIDDLE = "├── ";
    const SPACE = "    ";
    const LAST = "└── ";
    
    /*
     * Key Event handler.
     *
     * @access Public, Readonly
     *
     * @values Closure
     */
    public /** Readonly */ \Closure $eKey;
    
    /*
     * Recursive or Looping handler.
     *
     * @access Public, Readonly, Unused
     *
     * @values Closure, Looping
     */
    public /** Readonly */ \Looping $eRec;
    
    /*
     * Val Event handler.
     *
     * @access Public, Readonly
     *
     * @values Closure
     */
    public /** Readonly */ \Closure $eVal;
    
    /*
     * Array structure to be converted to tree form.
     *
     * @access Public, Readonly
     *
     * @values Array
     */
    public /** Readonly */ Array $array;
    
    private $spaces;
    private $result;
    private $caches;
    
    use Closure;
    
    public function __construct( Array $array, String | Int $start = 0, String $space = "", ? Callable $key = Null, ? Callable $val = Null, ? Callable $rec = Null )
    {
        if( $key === Null )
        {
            // // The default value for event key.
            $key = fn( $key ) => $key;
        }
        
        if( $rec !== Null )
        {
            if( self::config( "event.rec" ) === False )
            {
                //; The default value for event recursive.
            }
        }
        
        if( $val === Null )
        {
            // The default value for event value.
            $val = fn( $key, $val, $type ) => $val;
        }
        
        $this->eKey = $key;
        $this->eVal = $val;
        
        if( $start !== 0 )
        {
            for( $i = 0; $i < $start; $i++ )
            {
                $space .= " ";
            }
        }
        
        $this->result = $this->recursive( $this->space = $space, $this->array = $array );
    }
    
    /*
     * Returns the string content of an element.
     *
     * @access Public
     *
     * @return String
     */
    public function __toString(): String
    {
        return( $this->getResult() );
    }
    
    /*
     * Get Tree Struckture.
     *
     * @access Public
     *
     * @return String
     */
    public function getResult(): String
    {
        return( $this->result );
    }
    
    private function value( String $key, String $space, String $line, Mixed $val ): String
    {
        if( is_bool( $val ) ) {
            $re = $this->eVal( $key, $val, "Bool" );
        } else
        if( is_array( $val ) ) {
            $re = $this->recursive( $val, $space . $line );
        } else
        if( is_object( $val ) ) {
            $re = $this->eVal( $key, $val::class, "Object" );
        } else
        if( is_callable( $val ) ) {
            $re = $this->eVal( $key, "Closure", "Callable" );
        } else {
            $re = $this->eVal( $key, $val, "Unknown" );
        }
        return "{$re}\n";
    }
    
    private function recursive( String $space = "", Array $array = [] ): String
    {
        
        $it = 0;
        $re = "";
        
        if( count( $array ) !== 0 )
        {
            foreach( $array As $key => $val )
            {
                
                $it++;
                
                if( count( $array ) === $it )
                {
                    $lK = self::LAST;
                    $lA = self::SPACE;
                } else {
                    
                    $lK = self::MIDDLE;
                    $lA = self::STRAIGHT;
                }
                
                $re .= $space;
                $re .= $lK;
                
                if( is_int( $key ) )
                {
                    if( is_array( $val ) )
                    {
                        $re .= $this->eKey( 'Array' ) . "\n";
                        $re .= $this->recursive( $space . $lA, $val );
                    } else {
                        $re .= $this->value( $key, $space, $lA, $val );
                    }
                } else {
                    
                    $re .= $this->eKey( $key ) . "\n";
                    
                    if( is_array( $val ) )
                    {
                        $re .= $this->recursive( $space . $lA, $val );
                    } else {
                        $re .= $space;
                        $re .= $lA;
                        $re .= self::LAST;
                        $re .= $this->value( $key, $space, $lA, $val );
                    }
                }
            }
        } else {
            $re .= $space;
            $re .= self::LAST;
            $re .= $this->eVal( 'Array', "Empty", "Array" ) . "\n";
        }
        
        return $re;
    }
    
}

?>