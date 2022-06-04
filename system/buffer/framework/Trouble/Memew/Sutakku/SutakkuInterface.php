<?php

namespace Yume\Kama\Obi\Trouble\Memew\Sutakku;

use Throwable;

interface SutakkuInterface
{
    /*
     * Get Exception thrown
     *
     * @access Public
     *
     * @return Throwable
     */
    public function getObject(): Throwable;
    
    /*
     * Get Exception stack trace.
     *
     * @access Public
     *
     * @return Array
     */
    public function getStacks(): Array;
    
    /*
     * Get Exception previous
     *
     * @access Public
     *
     * @return Array, & Null
     */
    public function getPrevis(): ? Array;
}

?>