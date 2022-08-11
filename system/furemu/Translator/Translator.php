<?php

namespace Yume\Fure\Translator;

use Yume\Fure\AoE;
use Yume\Fure\Error;

/*
 * Translator
 *
 * @package Yume\Fure\Translator
 */
abstract class Translator
{
    
    protected static Array $lang = [];
    
    public static function import( String $lang ): Void
    {
        if( isset( self::$lang[$lang] ) )
        {
            return;
        }
        //self::$lang[$lang] = 
    }
    
    public static function translate( String $identifier, ? String $lang = Null ): String
    {
        
    }
    
}

?>