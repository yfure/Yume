<?php

namespace Yume\Kama\Obi\Trouble\Memew\Sutakku;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\RegExp;

use Throwable;

class Sutakku implements SutakkuInterface
{
    
    public $object;
    public $stacks = [];
    public $previs = [];
    
    public function __construct( Array | Throwable $object )
    {
        if( is_array( $object ) )
        {
            $i = 0;
            
            foreach( $object As $name => $previous )
            {
                if( $i !== 0 )
                {
                    $this->previs[$name] = new Sutakku( $previous );
                    $this->previs[$name] = $this->previs[$name]->stacks;
                } else {
                    $this->object = $previous;
                }
                $i++;
            }
        } else {
            $this->object = $object;
        }
        
        $this->stacks = $this->stack();
        
    }
    
    private function stack( ? Array $traces = Null )
    {
        if( $traces === Null )
        {
            /*
             * Get default scheme.
             *
             * @values Array
             */
            $traces  = AoE\App::config( "trouble.memew.scheme" );
        }
        
        $scheme = [];
        
        foreach( $traces As $key => $value )
        {
            if( is_array( $value ) )
            {
                $scheme[RegExp\RegExp::replace( $key, "/^\@([a-zA-Z]+)/", "$1" )] = $this->stack( $value );
            } else {
                
                $value = RegExp\RegExp::replace( $value, "/^\@([a-zA-Z]+)/", "$1" );
                
                $scheme[$value] = $this->trace( $value );
            }
        }
        return( $scheme );
    }
    
    private function trace( String $trace ): Mixed
    {
        return( match( $trace )
        {
            // The source of the thrown Throwable.
            "File" => path( $this->object->getFile(), True ),
            
            // Throwable class name.
            "Class" => $this->object::class,
            
            // List of Traits used.
            "Trait" => [],
            
            // Throwable parent class name.
            "Parent" => Null,
            
            // Throwable message.
            "Message" => path( $this->object->getMessage(), True ),
            
            // Get the previous exception.
            "Previous" => $this->object->getPrevious() !== Null ? $this->previs : [],
            
            // List of Interfaces implemented.
            "Interface" => Null,
            
            default => call_user_func( fn() => method_exists( $this->object, $method = format( "get{}", $trace ) ) ? $this->object->{ $method }() : "Undefined" )
            
        });
    }
    
}

?>