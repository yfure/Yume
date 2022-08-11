<?php

namespace Yume\Fure\Environment;

use Yume\Fure\Error;

/*
 * EnvironmentError
 *
 * @extends Yume\Fure\Error\TypeError
 *
 * @package Yume\Fure\Environment
 */
class EnvironmentError extends Error\TypeError
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
     * If the json value type is invalid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_ARRAY_VALUE = 8789;
    
    /*
     * If the variable prefix name is invalid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_PREFIX_NAME = 8793;
    
    /*
     * If the variable name is invalid.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_NAME = 8795;
    
    /*
     * If the variable value is invalid type.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const INVALID_VALUE_TYPE = 8798;
    
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    protected Array $flags = [
        self::DUPLICATE_CONSTANT => "The constant name for the environment variable {} has been duplicated.",
        self::DUPLICATE_SUPER_GLOBAL => "Unable to override super global \$_ENV[{}]",
        self::INVALID_ARRAY_VALUE => "The array value for \"{}\" must be valid value.",
        self::INVALID_PREFIX_NAME => "Environment prefix {} names must be all uppercase.",
        self::INVALID_NAME => "Environment variable names {} must be all uppercase.",
        self::INVALID_VALUE_TYPE => "The value of the environment variable {} must have the value {}, {} is given.",
    ];
    
}

?>