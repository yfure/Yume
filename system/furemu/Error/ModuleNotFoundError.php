<?php

namespace Yume\Fure\Error;

use Throwable;

/*
 * Error ModuleNotFoundError
 *
 * ModuleNotFoundError is thrown when a program module is not found.
 *
 * @package Yume\Fure\Error
 */
class ModuleNotFoundError extends BaseError
{
    
    /*
     * If component not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const COMPONENT = 4909;
    
    /*
     * If config not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const CONFIG = 5609;
    
    /*
     * If controller not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const CONTROLLER = 4509;
    
    /*
     * If environment not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const ENVIRONMENT = 4709;
    
    /*
     * If models not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const MODEL = 5109;
    
    /*
     * If no module name.
     *
     * @access Public
     *
     * @values Int
     */
    public const NAME = 5809;
    
    /*
     * If routes not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const ROUTES = 5409;
    
    /*
     * If view not found.
     *
     * @access Public
     *
     * @values Int
     */
    public const VIEW = 5309;
    
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    protected Array $flags = [
        self::CONTROLLER => "No controller named {}.",
        self::ENVIRONMENT => "File {} environment does not exist.",
        self::COMPONENT => "Component {} not found or may be missing.",
        self::MODEL => "Model {} is undefined or does not exist.",
        self::VIEW => "View {} has not been created.",
        self::ROUTES => "Module {} router configuration does not exist.",
        self::CONFIG => "Configuration module {} not found.",
        self::NAME => "No module named {}"
    ];
    
}

?>