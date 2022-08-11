<?php

namespace Yume\Fure\AoE\ITraits\Overloader;

/*
 * Overload
 *
 * @package Yume\Fure\AoE\ITraits\Overloader
 */
trait Overload
{
    /*
     * Location for overloaded data.
     *
     * @access Protected
     *
     * @values Array
     */
    protected Array $data = [];
    
    /*
     * An overloaded copy of the data.
     *
     * @access Protected
     *
     * @values Array
     */
    protected Array $copy = [];
}

?>