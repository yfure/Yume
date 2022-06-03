<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

class PSTraceApi
{
    
    /*
     * Stack Trace String.
     *
     * @access Public, Readonly
     *
     * @values String, Json
     */
    public /*Readonly*/ String $result;
    
    public function __construct( private PSTraceProvider $pstrace )
    {
        $this->result = $this->replace( json_encode( $pstrace->getTraces(), JSON_PRETTY_PRINT ) );
    }
    
    /*
     * Replace or Remove basepath filename.
     *
     * @access Public
     *
     * @params String <traces>
     *
     * @return String
     */
    public function replace( String $traces )
    {
        return( str_replace( [ str_replace( "/", "\\/", BASE_PATH ), "\\\\" ], [ "", "." ], $traces ) );
    }
    
}

?>