<?php

namespace Yume\Kama\Obi\Exception\PSTrace;

use Throwable;

interface PSTraceInterface
{
    
    /*
     * The PSTrace class instance.
     *
     * @access Public
     *
     * @params Array, Throwable <object>
     * @params Array <traces>
     *
     * @return Static
     */
    public function __construct( Array | Throwable $object, Array $traces );
    
    /*
     * Get Exception previous.
     *
     * @access Public
     *
     * @return
     */
    public function getPrev();
    
    /*
     * Get Exception traces.
     *
     * @access Public
     *
     * @return
     */
    public function getTraces();
    
    /*
     * Get Exception object.
     *
     * @access Public
     *
     * @return
     */
    public function getObject();
    
    /*
     * Get Exception result as string.
     *
     * @access Public
     *
     * @return
     */
    public function getResult();
    
}

?>