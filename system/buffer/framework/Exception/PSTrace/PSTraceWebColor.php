<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

class PSTraceWebColor
{
    protected $code = 6109;
    protected $message = 4669;
    protected $key = 5367;
    protected $string = 4492;
    protected $type = 2055;
    protected $class = 9147;
    protected $symbol = 7746;
    protected $file = 9449;
    protected $keyword = 5604;
    protected $trait = 6528;
    protected $interface = 2457;
    protected $function = 1359;
    protected $data = 7819;
    protected $mis = 3728;
    protected $empty = 5055;
    
    public function create( Mixed $val, String $type )
    {
        return( "<span class=\"hx{$this->{$type}}\">{$val}</span>" );
    }
}

?>