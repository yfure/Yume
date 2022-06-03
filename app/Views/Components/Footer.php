<?php

namespace App\Views\Components;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Sasayaki;

class Footer implements Sasayaki\Component\ComponentInterface
{
    
    use Sasayaki\Component\Component;
    
    /*
     * The Component Class Instance.
     *
     * @access Public
     *
     * @params String <index>
     * @params String <github>
     * @params String <twitter>
     * @params String <facebook>
     * @params String <instagram>
     *
     * @return Static
     */
    public function __construct( public String $index = "/", public String $github = "", public String $twitter = "", public String $facebook = "", public String $instagram = "" )
    {
        // Something ....
    }
    
}

?>