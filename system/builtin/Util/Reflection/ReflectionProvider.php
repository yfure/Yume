<?php

namespace Yume\Kama\Obi\Reflection;

abstract class ReflectionProvider implements ReflectionInterface
{
    /*
     * @inheritdoc Yume\Kama\Obi\Reflection\ReflectionReflectionInterface
     *
     */
    public static function self(): Mixed
    {
        return( __CLASS__ );
    }
}

?>