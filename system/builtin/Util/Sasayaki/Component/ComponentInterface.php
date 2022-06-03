<?php

namespace Yume\Kama\Obi\Sasayaki\Component;

use Yume\Kama\Obi\AoE;

interface ComponentInterface
{
    
    /*
     * Allows a class to decide how it will
     * React when it is treated like a string.
     * 
     * @access Public
     * 
     * @return String
     */
    public function __toString(): String;
    
    /*
     * Get contents that represent the component.
     *
     * @access Public
     *
     * @return String
     */
    public function render(): String;
    
}

?>