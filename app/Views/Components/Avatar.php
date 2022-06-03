<?php

namespace App\Views\Components;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Sasayaki;

final class Avatar implements Sasayaki\Component\ComponentInterface
{
    
    /*
     * The avatar radius level.
     *
     * @access Protected
     *
     * @values String
     */
    protected $rad;
    
    /*
     * The image alt.
     *
     * @access Protected
     *
     * @values String
     */
    protected $alt;
    
    /*
     * The image source
     *
     * @access Protected
     *
     * @values String
     */
    protected $src;
    
    use Sasayaki\Component\Component;
    
    /*
     * The Component Class Instance.
     *
     * @access Public
     *
     * @params String, Null <rad>
     * @params String, Null <alt>
     * @params String, Null <src>
     *
     * @return Static
     */
    public function __construct( ? String $rad = Null, ? String $src = Null, ? String $alt = Null )
    {
        if( $rad === Null )
        {
            $rad = "none";
        }
        
        // Set avatar radius.
        $this->rad = $rad;
        
        // Set image alt.
        $this->alt = "$alt";
        
        // Set image source.
        $this->src = "$src";
    }
    
}

?>