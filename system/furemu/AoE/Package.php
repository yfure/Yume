<?php

namespace Yume\Fure\AoE;

abstract class Package
{
    use ITraits\Package;
    
    /*
     * All packages installed.
     *
     * @access Public Static
     *
     * @values Array
     */
    public static Array $packages = [
        \Yume\Fure::class
    ];
    
}

?>