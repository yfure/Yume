<?php

namespace App\Views\Components;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Sasayaki;

class Navbar implements Sasayaki\Component\ComponentInterface
{
    
    /*
     * The navigation slide type.
     *
     * @access Prorected
     *
     * @values String
     */
    protected $sliding;
    
    use Sasayaki\Component\Component;
    
    /*
     * The Component Class Instance.
     *
     * @access Public
     *
     * @params String, Null <sliding>
     *
     * @return Static
     */
    public function __construct( ? String $sliding = Null )
    {
        if( $sliding === Null )
        {
            $sliding = "left";
        }
        $this->sliding = $sliding;
    }
    
}

?>