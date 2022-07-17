<?php

namespace Yume\Kama\Obi\AoE;

abstract class Package
{
    use Buffer\Package;
    
    /*
     * All packages installed.
     *
     * @access Public Static
     *
     * @values Array
     */
    public static Array $packages = [
        \Yume\Kama\Obi::class
    ];
    
}

?>