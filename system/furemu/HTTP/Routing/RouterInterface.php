<?php

namespace Yume\Fure\HTTP\Routing;

/*
 * RouterInterface
 *
 * @package Yume\Fure\HTTP\Routing
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