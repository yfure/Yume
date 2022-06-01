<?php

namespace Yume\Kama\Obi\Trouble;

/*
 * Trouble ModuleError
 *
 * Extend the ModuleNotFoundError class.
 *
 * @package Yume\Kama\Obi\Trouble
 */
class ModuleError extends ModuleNotFoundError
{
    /*
     * Construct method of class ModuleError.
     *
     * @access Public: Instance
     *
     * @params String: $message
     * @params String: $type
     *
     * @return Static
     */
    public function __construct( ? String $message = Null, ? String $module = Null, String $type = "None" )
    {
        if( $message === Null )
        {
            $message = match( $type )
            {
                
                // If controller not found.
                "controller" => "No controller named {}.",
                
                // If environment not found.
                "environment" => "File {} environment does not exist.",
                
                // If component not found.
                "component" => "Component {} not found or may be missing.",
                
                // If models not found.
                "model" => "Model {} is undefined or does not exist.",
                
                // If view not found.
                "view" => "View {} has not been created.",
                
                // If routes not found.
                "routes" => "Module {} router configuration does not exist.",
                
                // If config not found.
                "config" => "Configuration module {} not found.",
                
                // Unknown error type.
                "fone" => "No module named {}"
            };
        }
        parent::__construct( format( $message, path( $module, True ) ) );
    }
}

?>