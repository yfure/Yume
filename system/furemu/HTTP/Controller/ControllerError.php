<?php

namespace Yume\Fure\HTTP\Controller;

use Yume\Fure\Error;

/*
 * ControllerError
 *
 * @extends Yume\Fure\Error\BaseError
 *
 * @package Yume\Fure\HTTP\Controller
 */
class ControllerError extends Error\BaseError
{
    
    /*
     * If the controller does not implement the Controller Interface.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const IMPLEMENTS_ERROR = 5788;
    
    /*
     * If the controller doesn't define the main method to run.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const METHOD_ERROR = 5789;
    
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    protected Array $flags = [
        self::IMPLEMENTS_ERROR => "Controller class { } must implement Controller Interface.",
        self::METHOD_ERROR => "The controller {} class must define a main method to run, method \"{}\" is undefined."
    ];
    
}

?>