<?php

namespace Yume\Fure\Services;

/*
 * Services
 *
 * @package Yume\Fure\Services
 */
abstract class Services implements ServicesInterface
{
    
    /*
     * @inherit Yume\Fure\Services\ServicesInterface
     *
     */
    abstract public static function boot(): Void;
    
}

?>