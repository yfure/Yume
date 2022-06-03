<?php

namespace App\Views\Components;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Sasayaki;

class Header implements Sasayaki\Component\ComponentInterface
{
    
    /*
     * The avatar radius level.
     *
     * @access Protected
     *
     * @values String
     */
    protected $avatarRad;
    
    /*
     * The image alt.
     *
     * @access Protected
     *
     * @values String
     */
    protected $avatarAlt;
    
    /*
     * The image source
     *
     * @access Protected
     *
     * @values String
     */
    protected $avatarSrc;
    
    use Sasayaki\Component\Component;
    
    /*
     * The Component Class Instance.
     *
     * @access Public
     *
     * @return Static
     */
    public function __construct( ? String $avatarRad = Null, ? String $avatarAlt = Null, ? String $avatarSrc = Null )
    {
        if( $avatarRad === Null )
        {
            $avatarRad = "circle";
        }
        if( $avatarAlt === Null )
        {
            $avatarAlt = "";
        }
        if( $avatarSrc === Null )
        {
            $avatarSrc = "https://cdn-icons-png.flaticon.com/512/2885/2885034.png";
        }
        $this->avatarRad = $avatarRad;
        $this->avatarAlt = $avatarAlt;
        $this->avatarSrc = $avatarSrc;
    }
    
}

?>