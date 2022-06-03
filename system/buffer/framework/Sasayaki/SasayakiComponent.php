<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\Exception;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage;
use Yume\Kama\Obi\Reflection;

class SasayakiComponent extends SasayakiProvider implements SasayakiInterface
{
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $result = [];
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $content;
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $pattern = [
        
        // Multiple pattern.
        "/([\t]+)*\<component([\n|\t|\s|\r]+)*\:\:bind\=\"([^\"]*)\"([^\>]*)\>(.*?)\<\/component\>/si",
        
        // Single pattern.
        "/([\t]+)*\<component([\n|\t|\s|\r]+)*\:bind\=\"([^\"]*)\"([^\>]*)\>/si",
        
    ];
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function __construct( String | Storage\IO\Fairu $content, Array | AoE\Hairetsu $data, Array | AoE\Hairetsu & $refer = [] )
    {
        
        $this->results = new AoE\Data;
        $this->results->slots = new AoE\Data;
        
        /*
         * Parse to string if object
         *
         */
        if( is_object( $content ) )
        {
            $content = $content->reader();
        }
        
        /*
         * Search and Replace.
         *
         */
        $this->search( $content, $data );
        
        /*
         * Insert Variable results.
         */
        foreach( $this->result As $var => $value )
        {
            // Unhandled code.
        }
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function search( String $content, Array | AoE\Hairetsu $data ): Void
    {
        
        $this->content = $content;
        
        // Multipleline component replace.
        $this->content = HTTP\Filter\RegExp::replace( $this->pattern[0], $this->content, function( $m ) {
            
            // If component name is not empty.
            if( HTTP\Filter\RegExp::replace( "/\t|\n|\r|\s/", $m[3], "" ) !== "" )
            {
                
                $tabs = $m[1];
                $slot = $m[5];
                
                // Create new Reflection.
                $bind = Reflection\ReflectionInstance::reflect( $class = "App\\Views\\Components\\{$m[3]}" );
                
                // If the class does not implement ComponentInterface.
                if( $bind->implementsInterface( Component\ComponentInterface::class ) === False )
                {
                    throw new Exception\SasayakiException( "Class {$m[3]} must implement the interface " . Component\ComponentInterface::class );
                }
                
                $this->results->__isset( $class );
                
                // Render component.
                $bind = $bind->newInstanceArgs( $this->params( $m[4] ) )->render();
                
                // Replace component tabs.
                $bind = HTTP\Filter\RegExp::replace( "/\n/", "{$tabs}{$bind}", "\n{$tabs}" );
                
                // Get component slot templates.
                $templates = HTTP\Filter\RegExp::exec( "/([\t]+)*\<template.*?\:.*?bind\=\"([^\"]*)\".*?\>(.*?)<\/template\>/si", $slot );
                
                // Get component slots.
                $slots = HTTP\Filter\RegExp::exec( "/([\t]+)*\<slot.*?\:.*?name\=\"([^\"]*)\".*?\>(.*?)<\/slot\>/si", $bind );
                
                if( is_array( $templates ) )
                {
                    if( is_array( $slots ) )
                    {
                        foreach( $templates As $i => $template )
                        {
                            $bindC = $bind;
                            foreach( $slots As $i => $slot )
                            {
                                if( $slot[2] === $template[2] )
                                {
                                    $bind = str_replace( $slot[0], $template[3], $bind );
                                }
                            }
                            if( $bind === $bindC )
                            {
                                throw new Exception\SasayakiException( "Undefined slot \"{$template[2]}\" in component {$m[3]}." );
                            }
                        }
                        $bind = HTTP\Filter\RegExp::replace( "/([\t]+)*\<slot([\n|\t|\s|\r]+)*\:name\=\"([^\"]*)\"[^\>]*\>(.*?)<\/slot\>/si", $bind, fn( $m ) => str_replace( "$m[1]\t", $m[1], $m[4] ) );
                    }
                } else {
                    if( is_array( $slots ) && $slots[0][2] === "default" )
                    {
                        $bind = HTTP\Filter\RegExp::replace( "/([\t]+)*\<slot([\n|\t|\s|\r]+)*\:name\=\"default\"[^\>]*\>(.*?)<\/slot\>/si", $bind, fn( $m ) => str_replace( "$tabs\t", $m[1], $slot ) );
                    }
                }
                return( HTTP\Filter\RegExp::replace( "/\n([\t]+)*\n/", $bind, "\n" ) );
            }
            throw new Exception\SasayakiException( "Unable to create Anonymous component." );
        });
        
        // Single component replace.
        $this->content = HTTP\Filter\RegExp::replace( $this->pattern[1], $this->content, function( $m ) {
            
            // If component name is not empty.
            if( HTTP\Filter\RegExp::replace( "/\t|\n|\r|\s/", $m[3], "" ) !== "" )
            {
                $tabs = $m[1];
                
                // Create new Reflection.
                $bind = Reflection\ReflectionInstance::reflect( $class = "App\\Views\\Components\\{$m[3]}" );
                
                // If the class does not implement ComponentInterface.
                if( $bind->implementsInterface( Component\ComponentInterface::class ) === False )
                {
                    throw new Exception\InterfaceException( "The {$class} class must implement the " . Component\ComponentInterface::class . " interface." );
                }
                
                // Render component.
                $bind = $bind->newInstanceArgs( $this->params( $m[4] ) )->render();
                
                // Replace component tabs.
                $bind = HTTP\Filter\RegExp::replace( "/\n/", "{$tabs}{$bind}", "\n{$tabs}" );
                
                // Replace component slots.
                $bind = HTTP\Filter\RegExp::replace( "/([\t]+)*\<slot([\n|\t|\s|\r]+)*\:name\=\"([^\"]*)\"[^\>]*\>(.*?)<\/slot\>/si", $bind, function( $m ) use( $tabs ) {
                    if( HTTP\Filter\RegExp::match( "/\n([\t]+)*/", $m[4] ) )
                    {
                        return( str_replace( $m[1], "$tabs\t", $m[4] ) );
                    } else
                        return( "{$m[1]}{$m[4]}" );
                });
                
                return( $bind );
            }
            throw new Exception\SasayakiException( "Unable to create Anonymous component." );
        });
        

        
    }
    
    private function reloop( Array | Bool $param, Int $k = 0, Int $v = 0 ): Array
    {
        if( is_bool( $param ) )
        {
            $param = [];
        }
        foreach( $param As $i => $val )
        {
            if( $k !== 0 & $v !== 0 )
            {
                // Set new array element with key.
                $param[$val[$k]] = $val[$v];
            } else {
                
                // Set new array element.
                $param[] = $val[2];
            }
            // Unset array element.
            unset( $param[$i] );
        }
        return( $param );
    }
    
    private function params( String $params ): Array
    {
        return( $this->reloop( HTTP\Filter\RegExp::exec( "/\:([a-z0-9\_]+)\=\"([^\"]*)\"/i", HTTP\Filter\RegExp::replace( "/\:bind\=\".*?\"/", $params, "" ) ), 1, 2 ) );
    }
    
}

?>