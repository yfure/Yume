<?php

namespace Yume\Kama\Obi\HTTP\Controller;

use Yume\Kama\Obi\Trouble;

/*
 * ControllerError
 *
 * @extends Yume\Kama\Obi\Error\TroubleError
 *
 * @package Yume\Kama\Obi\HTTP\Controller
 */
class ControllerError extends Trouble\TroubleError
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
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    protected Array $flags = [
        self::IMPLEMENTS_ERROR => "Controller class { } must implement Controller Interface.",
        self::METHOD_ERROR => "The controller {} class must define a main method to run, method \"{}\" is undefined."
    ];
    
}

?>