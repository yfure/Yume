<?php

namespace Yume\Fure\AoE\ITraits\Overloader;

/*
 * Refresh
 *
 * @package Yume\Fure\AoE\ITraits\Overloader
 */
trait Refresh
{
    use Overload;
    
    /*
     * Reset data property values to initial values.
     *
     * @access Public
     *
     * @return Void
     */
    public function __reset(): Void
    {
        $this->data = $this->copy;
    }
}

?>