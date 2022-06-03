<?php

namespace App\Views\Components;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Sasayaki;

class Navbar extends Sasayaki\Component\Component implements Sasayaki\Component\ComponentInterface
{
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\Component\ComponentInterface
     *
     */
    public function __construct( Array | AoE\Hairetsu $args )
    {
        if( isset( $args['sliding'] ) === False )
        {
            $args['sliding'] = "left";
        }
        $this->args = $args;
    }
    
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
        return( view( "components.avatar", $this->args ) );
    }
    
    
}

?>