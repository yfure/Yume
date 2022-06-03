<?php

namespace Yume\Kama\Obi\HTTP\Route;

use Yume\Kama\Obi\AoE;

class Router extends AoE\Data
{
    
    /*
     * Route authentication.
     *
     * @access Public
     *
     * @values Bool
     */
    public $auth = False;
    
    /*
     * Route view page.
     *
     * @access Public
     *
     * @values String
     */
    public $view;
    
    /*
     * Route pattern.
     *
     * @access Public
     *
     * @values Array
     */
    public $where = [];
    
    /*
     * Route headers.
     *
     * @access Public
     *
     * @values Array
     */
    public $header = [];
    
    /*
     * Route redirect.
     *
     * @access Public
     *
     * @values String
     */
    public $redirect;
    
    public $response;
    public $responseCode;
    
    protected $parent;
    
    /*
     * @inheritdoc Yume\Kama\Obi\AoE\Hairetsu
     *
     */
    public function __construct( Array $data = [] )
    {
        
        if( isset( $data['group'] ) )
        {
            $data['group'] = new RouteGroup( $data['group'] );
        }
        
        parent::__construct( $data );
    }
    
    /*
     * [E|Dis]nable authentication for pages.
     *
     * @access Public
     *
     * @params Bool
     *
     * @return Static
     */
    public function auth( Bool $auth ): Static
    {
        // Set [E|Dis]nable authentication.
        $this->auth = $auth;
        
        return( $this );
    }
    
    /*
     * Set a view for the page.
     * Keep in mind that this will only
     * Apply if the user is not logged in.
     *
     * @access Public
     *
     * @params String, Callable <view>
     *
     * @return Static
     */
    public function view( String | Callable $view )
    {
        // Set view page.
        $this->view = $view;
        
        return( $this );
    }
    
    /*
     * Set pattern for URI segment.
     *
     * @access Public
     *
     * @params String <segment>
     * @params String <pattern>
     *
     * @return Static
     */
    public function where( String $segment, String $pattern ): Static
    {
        // Insert new segment pattern.
        $this->where[$segment] = $pattern;
        
        return( $this );
    }
    
    /*
     * Set a raw HTTP header.
     *
     * @access Public
     *
     * @params String <header>
     * @params Bool <replace>
     * @params Int <response>
     *
     * @return Static
     */
    public function header( String $header, Bool $replace = True, Int $response = 0 )
    {
        // Insert new header.
        $this->header[] = [
            
            // Header HTTP raw.
            $header,
            
            // Replace header.
            $replace,
            
            // If the code contains zero it will not
            // Be passed to the [header] function parameter.
            $response
            
        ];
        return( $this );
    }
    
    /*
     * Set redirect route.
     *
     * @access Public
     *
     * @params String <route>
     *
     * @return Static
     */
    public function redirect( String $route ): Static
    {
        // Set redirect.
        $this->redirect = $route;
        
        return( $this );
    }
    
    /*
     * Set page response type.
     *
     * @access Public
     *
     * @params String <response>
     *
     * @return Static
     */
    public function response( String $response = "html", Int $code = 404 ): Static
    {
        $this->response = match( $response )
        {
            
            /*
             * Multiple responses supported.
             *
             */
            'aac' => "audio/aac",
            'abw' => "application/x-abiword",
            'arc' => "application/x-freearc",
            'avif' => "image/avif",
            'avi' => "video/x-msvideo",
            'azw' => "application/vnd.amazon.ebook",
            'bin' => "application/octet-stream",
            'bmp' => "image/bmp",
            'bz' => "application/x-bzip",
            'bz2' => "application/x-bzip2",
            'cda' => "application/x-cdf",
            'csh' => "application/x-csh",
            'css' => "text/css",
            'csv' => "text/csv",
            'doc' => "application/msword",
            'docx' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            'eot' => "application/vnd.ms-fontobject",
            'epub' => "application/epub+zip",
            'gz' => "application/gzip",
            'gif' => "image/gif",
            'htm' => "text/html",
            'html' => "text/html",
            'ico' => "image/vnd.microsoft.icon",
            'ics' => "text/calendar",
            'jar' => "application/java-archive",
            'jpg' => "image/jpeg",
            'jpeg' => "image/jpeg",
            'js' => "text/javascript",
            'json' => "application/json",
            'jsonld' => "application/ld+json",
            'mid' => "audio/midi",
            'midi' => "audio/x-midi",
            'mjs' => "text/javascript",
            'mp3' => "audio/mpeg",
            'mp4' => "video/mp4",
            'mpeg' => "video/mpeg",
            'mpkg' => "application/vnd.apple.installer+xml",
            'odp' => "application/vnd.oasis.opendocument.presentation",
            'ods' => "application/vnd.oasis.opendocument.spreadsheet",
            'odt' => "application/vnd.oasis.opendocument.text",
            'oga' => "audio/ogg",
            'ogv' => "video/ogg",
            'ogx' => "application/ogg",
            'opus' => "audio/opus",
            'otf' => "font/otf",
            'png' => "image/png",
            'pdf' => "application/pdf",
            'php' => "application/x-httpd-php",
            'ppt' => "application/vnd.ms-powerpoint",
            'pptx' => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            'rar' => "application/vnd.rar",
            'rtf' => "application/rtf",
            'sh' => "application/x-sh",
            'svg' => "image/svg+xml",
            'swf' => "application/x-shockwave-flash",
            'tar' => "application/x-tar",
            'tif' => "image/tiff",
            'tiff' => "image/tiff",
            'ts' => "video/mp2t",
            'ttf' => "font/ttf",
            'txt' => "text/plain",
            'vsd' => "application/vnd.visio",
            'wav' => "audio/wav",
            'weba' => "audio/webm",
            'webm' => "video/webm",
            'webp' => "image/webp",
            'woff'  => "font/woff",
            'woff2' => "font/woff2",
            'xhtml' => "application/xhtml+xml",
            'xls' => "application/vnd.ms-excel",
            'xlsx' => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            'xml' => "application/xml",
            'xul' => "application/vnd.mozilla.xul+xml",
            'zip' => "application/zip",
            '3gp' => "audio/video",
            '3g2' => "audio/video",
            
            /*
             * If there's none.
             *
             */
            default => $response
            
        };
        return( $this );
    }
    
}

?>