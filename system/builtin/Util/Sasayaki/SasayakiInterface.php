<?php

namespace Yume\Kama\Obi\Sasayaki;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Storage\IO;

interface SasayakiInterface
{
    
    /*
     * The SasayakiClass instance.
     *
     * @access Public
     *
     * @params String, Yume\Kama\Obi\Storage\IO\Fairu <content>
     * @params Array, Yume\Kama\Obi\AoE\Hairetsu <data>
     * @params Array, Yume\Kama\Obi\AoE\Hairetsu <refer>
     *
     * @return Static
     */
    public function __construct( 
        String | IO\Fairu $content, 
        Array | AoE\Hairetsu $data, 
        Array | AoE\Hairetsu & $refer = [] 
    );
    
    /*
     * Search and Replace by pattern.
     *
     * @access Public
     *
     * @params String <content>
     * @params Array, Yume\Kama\Obi\AoE\Hairetsu <data>
     *
     * @return Void
     */
    public function search( String $content, Array | AoE\Hairetsu $data ): Void;
    
    /*
     * Return result pattern.
     *
     * @access Public
     *
     * @return String
     */
    public function getResult(): Array;
    
    /*
     * Return content replaced.
     *
     * @access Public
     *
     * @return String
     */
    public function getContent(): String;
    
    /*
     * Return regex pattern.
     *
     * @access Public
     *
     * @return String
     */
    public function getPattern(): String;
    
}

?>