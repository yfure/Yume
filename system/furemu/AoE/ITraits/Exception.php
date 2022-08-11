<?php

namespace Yume\Fure\AoE\ITraits;

use Throwable;

/*
 * Exception
 *
 * @package Yume\Fure\AoE\ITraits
 */
trait Exception
{
    /*
     * Value of flag (e.g...[ self::NAME_ERROR => "Name for {} is undefined" ])
     *
     * @access Protected
     *
     * @values Array
     */
    protected Array $flags = [];
    
    /*
     * Exception type thrown.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $type = "None";
    
    /*
     * Gets exception type.
     *
     * @access Public
     *
     * @return String
     */
    public function getType(): String
    {
        return( $this->type );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
     *
     */
    public function __toString(): String
    {
        return( path( remove: True, path: f( "{}: {} on file {} line {} code {}.", $this::class, $this->message, $this->file, $this->line, $this->code ) ) );
    }
}

?>