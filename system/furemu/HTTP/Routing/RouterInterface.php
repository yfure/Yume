<?php

namespace Yume\Kama\Obi\HTTP\Routing;

/*
 * RouterInterface
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
interface RouterInterface
{
    
    /*
     * Create new routing.
     *
     * @access Public
     *
     * @return Void
     */
    public function create(): Void;
    
    /*
     * Route dispatch.
     *
     * @access Public
     *
     * @return Void
     */
    public function dispatch(): Void;
    
}

?>