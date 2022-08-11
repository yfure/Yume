<?php

namespace Yume\Fure\Database;

use Yume\Fure\Error;

/*
 * DatabaseError
 *
 * @extends Yume\Fure\Error\RuntimeError
 *
 * @package Yume\Fure\Database
 */
class DatabaseError extends Error\RuntimeError
{
    /*
     * If connection name is undefined.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const CONNECTION_ERROR = 6275;
    
    /*
     * If the database driver is not supported.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const DRIVER_ERROR = 6478;
    
    /*
     * If the database server is not supported.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const SERVER_ERROR = 6779;
    
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    protected Array $flags = [
        self::CONNECTION_ERROR => "Database has no connection with name \"{}\".",
        self::DRIVER_ERROR => "Driver \"{}\" for database \"{}\" is not supported.",
        self::SERVER_ERROR => "Invalid or unsupported server database type for \"{}\"."
    ];
}

?>