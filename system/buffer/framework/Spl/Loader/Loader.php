<?php

namespace Yume\Kama\Obi\Spl\Loader;

use function Yume\Func\config;
use function Yume\Func\path;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Spl;
use Yume\Kama\Obi\Trouble;

class Loader
{
    protected static $configs;
    
    protected static $classes = [];
    
    /*
     * Registering autoloader class.
     *
     * @access Public
     *
     * @return Void
     */
    public static function init()
    {
        // Loader configuration.
        // If logging is allowed.
        if( ( self::$configs = config( "app.loader" ) ) ['save'] )
        {
            self::$classes = [
                \Yume\Kama\Obi::class => [
                    \Spl::class => [
                        \Autoload::class,
                        \Package::class => [
                            \Package::class
                        ],
                        \Loader::class => [
                            \Loader::class
                        ]
                    ]
                ]
            ];
        }
        
        // If Spl extension is loaded.
        if( extension_loaded( "spl" ) )
        {
            
            // Register a Loader Methods to load
            // The class automatically when needed.
            Spl\Autoload::register([ __CLASS__, "loader" ]);
            
        } else {
            die( "SPL extension not loaded!" );
        }
        
    }
    
    /*
     * Load the class if the namespace matches.
     *
     * @access Public, Static
     *
     * @params String <class>
     *
     * @return Void
     */
    public static function loader( String $class ): Void
    {
        foreach( self::$configs['spaces'] As $space => $groups )
        {
            
            // Recognizing backslash characters.
            $name = str_replace( "\\", "\\\\", $space );
            
            // If namespace is allowed.
            if( self::match( $name, $class ) )
            {
                
                // Create file name.
                $file = $groups['path'] . Spl\Package\Package::fileName( str_replace( "{$space}\\", "", $class ), $space );
                
                /*
                 * To avoid class name collision I added
                 * checking whether class already exists
                 * or not because, one file can contain
                 * two classes or even more.
                 *
                 */
                if( class_exists( $class ) === False )
                {
                    self::import( $file );
                }
                
                // If logging is allowed.
                if( self::$configs['save'] )
                {
                    self::$classes[$space] = self::save( $space, $class, $groups['tree'], isset( self::$classes[$space] ) ? self::$classes[$space] : [] );
                }
                
                return;
            }
        }
    }
    
    /*
     * Import Class File.
     *
     * @access Public, Static
     *
     * @params String <file>
     *
     * @return Mixed
     */
    public static function import( String $file ): Mixed
    {
        // If the file exists.
        if( file_exists( path( base: $file ) . ".php" ) )
        {
            // Importing utils by class name.
            return( require( path( base: $file ) . ".php" ) );
        }
        throw new Trouble\Exception\ModuleError( "No module named $file" );
    }
    
    public static function match( String $pattern, String $subject ): Bool
    {
        return preg_match( "/{$pattern}/", $subject );
    }
    
    /*
     * Save Class Loaded.
     *
     * @access Private, Static
     *
     * @params String <space>
     * @params String <class>
     * @params Array <groups>
     * @params Array <value>
     *
     * @return Array
     */
    public static function save( String $space, String $class, Array $groups, Array $value ): Array
    {
        if( count( $groups ) !== 0 ) {
            foreach( $groups As $key => $val ) {
                if( is_array( $val ) ) {
                    if( count( $loop = self::save( "$space\\$key", $class, $val, ( isset( $value[$key] )? $value[$key] : [] ) ) ) !== 0 ) {
                        $value[$key] = $loop;
                    }
                } else {
                    if( "$space\\$val" === Spl\Package\Package::nameSpace( $class ) ) {
                        $value[$val][] = Spl\Package\Package::className( $class );
                    } else {
                        if( "$space" === Spl\Package\Package::nameSpace( $class ) ) {
                            if( in_array( $class = Spl\Package\Package::className( $class ), $value ) === False ) {
                                $value[] = $class;
                            }
                        }
                    }
                }
            }
        }
        return $value;
    }

    /*
     * Dumping all classes that have been removed.
     * 
     * @access Public, Static
     * 
     * @return Void
     */
    public static function dump(): Void
    {
        // Create new Tree Structure.
        $tree = new AoE\Tree( self::$classes );
        
        // Show Tree Classes.
        echo( $tree->getResult() );
    }
    
}

?>