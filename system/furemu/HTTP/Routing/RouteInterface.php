<?php

namespace Yume\Fure\HTTP\Routing;

/*
 * RouteInterface
 *
 * @package Yume\Fure\HTTP\Routing
 */
interface RouteInterface
{
    
    /*
     * Return all child routes.
     *
     * @access Public
     *
     * @return Yume\Fure\HTTP\Routing\Routes
     */
    public function getChild(): ? Routes;
    
    /*
     * Return route handler.
     *
     * @access Public
     *
     * @return Array|Object|String|Callable
     */
    public function getHandler(): Array | Object | String | Callable;
    
    /*
     * Return all headers.
     *
     * @access Public
     *
     * @return Array
     */
    public function getHeader(): Array;
    
    /*
     * Return route method.
     *
     * @access Public
     *
     * @return String
     */
    public function getMethod(): String;
    
    /*
     * Return route name.
     *
     * @access Public
     *
     * @return String
     */
    public function getName(): ? String;
    
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