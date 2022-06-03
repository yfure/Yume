<?php

namespace Yume\Kama\Obi\HTTP\Filter;

class RegExp
{
    use \Yume\Kama\Obi\AoE\Config;
    
    /*
     * Perform a global regular expression match.
     *
     * @access Public, Static
     *
     * @params String <pattern>
     * @params String <subject>
     * @params Int <flags>
     * @params Int <offset>
     *
     * @return Array, False
     */
    public static function exec( String $pattern, String $subject, Int $flags = PREG_SET_ORDER, Int $offset = 0 ): Array | False
    {
        $matches = [];
        
        // Return global regular expression match result.
        return( preg_match_all( $pattern, $subject, $matches, $flags, $offset ) ? $matches : False );
    }
    
    public static function grep(  )
    {
        
    }
    
    /*
     * Perform a regular expression match.
     *
     * @access Public, Static
     *
     * @params String <pattern>
     * @params String <subject>
     * @params Array <matches>
     * @params Int <flags>
     * @params Int <offset>
     *
     * @return Bool
     */
    public static function match( String $pattern, String $subject, Array &$matches = Null, Int $flags = 0, Int $offset = 0 ): Int | False
    {
        return( preg_match( $pattern, $subject, $matches, $flags, $offset ) );
    }
    
    public static function quote(  )
    {
        
    }
    
    public static function errno(  )
    {
        
    }
    
    public static function error(  )
    {
        
    }
    
    /*
     * Split string by a regular expression.
     *
     * @access Public, Static
     *
     * @params String <pattern>
     * @params String <subject>
     * @params Int <limit>
     * @params Int <flags>
     *
     * @return Array, False
     */
    public static function split( String $pattern, String $subject, Int $limit = -1, Int $flags = 0 ): Array | False
    {
        return preg_split( $pattern, $subject, $limit, $flags );
    }
    
    /*
     * Perform a regular expression search and replace.
     *
     * @access Public, Static
     *
     * @params Array, String <pattern>
     * @params Array, String <replace>
     * @params Array, String <subject>
     * @params Int <limit>
     * @params Int <count>
     *
     * @return Array, String, Null
     */
    public static function filter( Array | String $pattern, Array | String $replace, Array | String $subject, Int $limit = -1, Int &$count = Null ): Array | String | Null
    {
        return preg_filter( $pattern, $replace, $subject, $limit, $count );
    }
    
    /*
     * Perform a regular expression search
     * And replace using callback or string.
     *
     * @access Public, Static
     *
     * @params Array, String <pattern>
     * @params Array, String <subject>
     * @params Array, String, Callable <replace>
     * @params Int <limit>
     * @params Int <count>
     * @params Int <flags>
     *
     * @return Array, String, Null
     */
    public static function replace( Array | String $pattern, Array | String $subject, Array | String | Callable $replace, Int $limit = -1, Int &$count = Null, Int $flags = 0 ): Array | String | Null
    {
        if( is_callable( $replace ) ) {
            
            // Search and replace using a callback.
            return( preg_replace_callback( $pattern, $replace, $subject, $limit, $count, $flags ) );
        }
        
        // Search and replace using a string or array.
        return( preg_replace( $pattern, $replace, $subject, $limit, $count ) );
    }
    
    /*
     * Get pattern stored in config.
     *
     * @access Public, Static
     *
     * @params String
     *
     * @return Array, String, Null
     */
    public static function pattern( String $pattern ): Array | String | Null
    {
        // Get all patterns.
        if( $patterns = self::config( "patterns" ) ) {
            if( isset( $patterns[$pattern] ) ) {
                return $patterns[$pattern];
            }
        }
        return Null;
    }
    
}

?>