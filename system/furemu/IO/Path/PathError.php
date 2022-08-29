<?php

namespace Yume\Fure\IO\Path;

use Yume\Fure\IO;

/*
 * PathError
 *
 * DirectoryError will only be thrown
 * if there is an error in the directory.
 *
 * @extends Yume\Fure\IO\IOError
 *
 * @package Yume\Fure\IO\Path
 */
class PathError extends IO\IOError
{
    /*
     * If the directory is not executeable.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const NOT_EXECUTEABLE = 9876;
    
    /*
     * If the directory is not directory.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const NOT_DIRECTORY = 9877;
    
    /*
     * If the directory is not found.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const NOT_FOUND = 9878;
    
    /*
     * If the directory is not readable.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const NOT_READABLE = 9879;
    
    /*
     * If the directory is not writeable.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const NOT_WRITEABLE = 9880;
    
    /*
     * @inherit Yume\Fure\Error\BaseError
     *
     */
    protected Array $flags = [
        self::NOT_EXECUTEABLE => "Path {} cannot be executed.",
        self::NOT_DIRECTORY => "Path {} is not a directory.",
        self::NOT_FOUND => "Path {} not found.",
        self::NOT_READABLE => "Path {} cannot be read.",
        self::NOT_WRITEABLE => "Path {} is not writable.",
    ];
    
}

?>