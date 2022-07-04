<?php

namespace Yume\Kama\Obi\HTTP\Routing;

/*
 * RouteInterface
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
interface RouteInterface
{
    
    /*
     * Return all child routes.
     *
     * @access Public
     *
     * @return Yume\Kama\Obi\HTTP\Routing\Routes
     */
    public function getChild(): ? Routes;
    
    /*
     * Return all headers.
     *
     * @access Public
     *
     * @return Array
     */
    public function getHeader(): Array;
    
    /*
     * Return route path.
     *
     * @access Public
     *
     * @return String
     */
    public function getPath(): String;
    
    /*
     * Return regular expression route.
     *
     * @access Public
     *
     * @return String
     */
    public function getRegExp(): String;
    
    /*
     * Return all route path segments.
     *
     * @access Public
     *
     * @return Array
     */
    public function getSegment(): Array;
    
}

?>