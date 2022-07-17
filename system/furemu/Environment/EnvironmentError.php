<?php

namespace Yume\Kama\Obi\Environment;

use Yume\Kama\Obi\Trouble;

/*
 * EnvironmentError
 *
 * @extends Yume\Kama\Obi\Trouble\TypeError
 *
 * @package Yume\Kama\Obi\Environment
 */
class EnvironmentError extends Trouble\TypeError
{
    
    /*
     * If the constant name has been defined.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const DUPLICATE_CONSTANT = 8784;
    
    /*
     * If the super global name of the constant cannot be overwritten.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const DUPLICATE_SUPER_GLOBAL = 8785;
    
    /*
     * If the variable prefix name is invalid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_PREFIX_NAME = 8786;
    
    /*
     * If the variable name is invalid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_NAME = 8787;
    
    /*
     * If the variable value is invalid type.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_VALUE_TYPE = 8788;
    
    /*
     * @inherit Yume\Kama\Obi\Trouble\TroubleError
     *
     */
    protected Array $flags = [
        self::DUPLICATE_CONSTANT => "The constant name for the environment variable {} has been duplicated.",
        self::DUPLICATE_SUPER_GLOBAL => "Unable to override super global \$_ENV[{}]",
        self::INVALID_PREFIX_NAME => "Environment prefix {} names must be all uppercase.",
        self::INVALID_NAME => "Environment variable names {} must be all uppercase.",
        self::INVALID_VALUE_TYPE => "The value of the constant {} must have the value {}, {} is given.",
    ];
    
}

?>