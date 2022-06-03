<?php

namespace Yume\Kama\Obi\Sasayaki;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Storage\IO;
use Yume\Kama\Obi\Reflection;

class SasayakiResource extends SasayakiProvider implements SasayakiInterface
{
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $result = [];
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $content;
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiProvider
     *
     */
    protected $pattern = "/([\t]+)*\@import\[([^\]]+)\]\;/si";
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function __construct( String | IO\Fairu $content, Array | AoE\Hairetsu $data, Array | AoE\Hairetsu & $refer = [] )
    {
        
        /*
         * Parse to string if object
         *
         */
        if( is_object( $content ) )
        {
            $content = $content->reader();
        }
        
        /*
         * Search and Replace.
         *
         */
        $this->search( $content, $data );
        
        /*
         * Insert Variable results.
         */
        foreach( $this->result As $var => $value )
        {
            $refer[$var] = $value;
        }
    }
    
    /*
     * @inheritdoc Yume\Kama\Obi\Sasayaki\SasayakiInterface
     *
     */
    public function search( String $content, Array | AoE\Hairetsu $data ): Void
    {
        $this->content = HTTP\Filter\RegExp::replace( $this->pattern, $content, function( $m ) {
            if( $e = HTTP\Filter\RegExp::exec( "/(\/[a-z0-9\_\-\.\/]+)(\{([^\}]+)\})*/i", $m[2] ) )
            {
                $r = "";
                foreach( $e As $e )
                {
                    if( isset( $e[3] ) )
                    {
                        if( $e[3] === "js" )
                        {
                            $r .= $this->minify( $this->import( "{$e[1]}.js" ), "js" );
                        } else
                        if( $e[3] === "css" )
                        {
                            $r .= $this->minify( $this->import( "{$e[1]}.css" ), "css" );
                        } else
                        if( $e[3] === "saimin" )
                        {
                            $r .= view( $e[1] );
                        } else {
                            $r .= htmlspecialchars( $this->import( "{$e[1]}.{$e[3]}" ) );
                        }
                    } else {
                        $r .= htmlspecialchars( $this->import( $e[1] ) );
                    }
                }
                return( HTTP\Filter\RegExp::replace( "/\n/", "{$m[1]}{$r}", "\n{$m[1]}" ) );
            }
        });
    }
    
    private function import( String $file ): String
    {
        return( new IO\Fairu( $file ) )->reader();
    }
    
    private function minify( String $file, String $e ): String
    {
        $r = HTTP\Filter\RegExp::replace( "/http([s])*\:\/\//", $file, "http..$1" );
        
        if( $e === "css" )
        {
            $r = HTTP\Filter\RegExp::replace( "/\/\/([^\n]+)\n/", $r, "" );
        }
        
        $r = HTTP\Filter\RegExp::replace( "/\/\*[\s\S]*?\*\/|\r|\t|\n|\s\s/s", $r, "" );
        $r = HTTP\Filter\RegExp::replace( "/http\.\.(s)*/", $r, "http$1://" );
        
        return $r;
    }
    
}

?>