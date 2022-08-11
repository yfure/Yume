<?php

namespace Yume\Fure\AoE;

/*
 * Overloader
 *
 * @package Yume\Fure\AoE
 */
abstract class Overloader
{
    use ITraits\Overloader\Overload;
    
    /*
     * Construct method of class Overloader.
     *
     * @access Public Instance
     *
     * @params Array $data
     *
     * @return Void
     */
    public function __construct( Array $data = [] )
    {
        $this->copy = $this->data = $data;
    }
}

?>