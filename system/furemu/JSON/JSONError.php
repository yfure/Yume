<?php

namespace Yume\Fure\JSON;

use Yume\Fure\Error;

/*
 * JSONError
 *
 * @package Yume\Fure\JSON
 */
class JSONError extends Error\TypeError
{
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const NONE_ERROR = 0;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const DEPTH_ERROR = 1;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const STATE_MISMATCH_ERROR = 2;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const CTRL_CHAR_ERROR = 3;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const SYNTAX_ERROR = 4;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const UTF8_ERROR = 5;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const RECURSION_ERROR = 6;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const INF_OR_NAN_ERROR = 7;
    
    /*
     * @inherit https://www.php.net/manual/en/function.json-last-error-msg.php
     *
     */
    public const UNSUPPORTED_TYPE_ERROR = 8;
    
}

?>