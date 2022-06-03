<?php

namespace Yume\Kama\Obi\HTTP\Session;

interface SessionHandlerInterface
{
    public function __construct( String $iv, ?String $key = Null, ?Array $password = Null );
}

?>