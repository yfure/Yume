<?php

namespace App\Views\Components;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Sasayaki;

final class Test implements Sasayaki\Component\ComponentInterface
{
    
    /*
     * The parameter testing.
     *
     * @access Protected
     *
     * @values String
     */
    protected $params;
    
    use Sasayaki\Component\Component;
    
    /*
     * The Component Class Instance.
     *
     * @access Public
     *
     * @params String, Null <params>
     *
     * @return Static
     */
    public function __construct( ? String $params )
    {
        $this->params = $params;
    }
    
}

?>