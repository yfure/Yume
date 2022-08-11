<?php

namespace Yume\Fure\Logger;

/*
 * LoggerHandlerInterface
 *
 * @package Yume\Fure\Logger
 */
interface LoggerHandlerInterface
{
    /*
     * Write new logger.
     *
     * @access Public
     *
     * @params String $message
     * @params String $file
     * @params String $save
     *
     * @return Void
     */
    public function write( String $message, String $file, String $save ): Void;
}

?>