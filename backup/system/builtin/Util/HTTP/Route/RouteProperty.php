<?php

namespace Yume\Kama\Obi\HTTP\Route;

/*
 * RouteProperty utility trait.
 *
 * @package Yume\Kama\Obi\HTTP\Route
 */
trait RouteProperty
{
    
    /*
     * Return route path.
     *
     * @access Public
     *
     * @return String
     */
    public function getPath(): String
    {
        return( $this->path );
    }
    
    /*
     * Return route meta.
     *
     * @return Int, Null
     */
    public function getMeta(): ? Int
    {
        return( $this->meta );
    }
    
    /*
     * Return route group.
     *
     * @return Null, Yume\Kama\Obi\HTTP\Route\RouteGroup
     */
    public function getGroup(): ? RouteGroup
    {
        return( $this->group );
    }
    
    /*
     * Return route where.
     *
     * @return Array
     */
    public function getWhere(): Array
    {
        return( $this->where );
    }
    
    /*
     * Return route method.
     *
     * @return Array, String
     */
    public function getMethod(): Array | String
    {
        return( $this->method );
    }
    
    /*
     * Return route parent.
     *
     * @access Public
     *
     * @return Null, String
     */
    public function getParent(): ? String
    {
        return( $this->parent );
    }
    
    /*
     * Return route params.
     *
     * @access Public
     *
     * @return Array
     */
    public function getParams(): Array
    {
        return( $this->params );
    }
    
    /*
     * Return route pattern.
     *
     * @access Public
     *
     * @return Array, Null, String
     */
    public function getPattern(): Array | Null | String
    {
        return( $this->pattern );
    }
    
    /*
     * Return route segment.
     *
     * @access Public
     *
     * @return Array
     */
    public function getSegment(): Array
    {
        return( $this->segment );
    }
    
    /*
     * Return route headers.
     *
     * @access Public
     *
     * @return Array
     */
    public function getHeaders(): Array
    {
        return( $this->headers );
    }
    
    /*
     * Return route response.
     *
     * @access Public
     *
     * @return Null, String
     */
    public function getResponse(): ? String
    {
        return( $this->response() );
    }
    
}

?>