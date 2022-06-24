<?php

namespace Yume\Kama\Obi\Environment;

use Yume\Kama\Obi\AoE;

use Dotenv;

/*
 * Environment Class
 *
 * ....
 *
 * @inherit Yume\Kama\Obi\AoE\App
 * @package Yume\Kama\Obi\Environment
 */
abstract class Environment extends AoE\App
{
    
    /*
     * The Dotenv instance class.
     *
     * @access Public: Static
     *
     * @values Dotenv\Dotenv
     */
    public static $onload;
    
    /*
     * Loading environment files.
     *
     * @access Public: Static
     *
     * @return Void
     */
    public static function onload(): Object
    {
        return( self::$onload = Dotenv\Dotenv::createImmutable( BASE_PATH, parent::config( "environment.name" ) )  );
    }
    
}

?>