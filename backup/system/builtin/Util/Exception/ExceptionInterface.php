<?php

namespace Yume\Kama\Obi\Exception;

use Throwable;

interface ExceptionInterface
{
    /*
     * The Exception class instance.
     *
     * @access Public
     *
     * @params Object, String <class>
     * @params String <message>
     * @params Int <code>
     * @params Throwable, Null <prev>
     *
     * @return Static
     */
    public function __construct( Object | String $class, String $message, Int $code = 0, ? Throwable $prev = Null );
}

?>