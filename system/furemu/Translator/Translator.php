<?php

namespace Yume\Kama\Obi\Translator;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Trouble;

/*
 * Translator
 *
 * @package Yume\Kama\Obi\Translator
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