<?php

namespace Yume\Kama\Obi\Sasayaki\Component;

use function Yume\Func\view;

use Yume\Kama\Obi\Exception;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Spl;

trait Component
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\Component\ComponentInterface
     *
     */
    public function __toString(): String
    {
        return( __CLASS__ );
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\Component\ComponentInterface
     *
     */
    public function render(): String
    {
        // Get the current object property.
        $data = new AoE\Data( get_object_vars( $this ) );
        
        // Get component name by class name.
        $component = Spl\Package\Package::className( strtolower( $this ) );
        
        // Get view of content.
        return( view( "components.{$component}", $data ) );
    }
    
}

?>