<?php

return [
    
    'cookie' => [
        
        'driver' => Yume\Kama\Obi\HTTP\Cookie\Cookie::class,
        
        /*
         * Cookie Key & Val Encryption Password.
         *
         * Encryption Key for cookie name as well as cookie value.
         * Assign <False> to key or val to disable encryption of key as well as val.
         *
         */
        'encrypt' => [
            'key' => "3c2f264eaf0d748421151fabe4ea7f0fc2a18951260a69eb5dde16de8cb51c0c4a55160caa7a7b52e3ab5c0078a3702bf797b2cabdfe0d04aea3ac89235cb132",
            'val' => "aa66dc54bd12563c8d931382aec1427fae60c4ac7993744682d241c83b5b33a56c9ffd414d61d89fd1bc9f76ce8f9b8d0b1e29e55b16ac99c79edff1fd3ff023"
        ]
        
    ],
    
    'session' => [
        
        /*
         * Session Key & Val Encryption Password.
         *
         * Encryption Key for cookie name as well as session value.
         * Assign <False> to key or val to disable encryption of key as well as val.
         */
        'encrypt' => [
            'key' => "953yjh3oWQjrc+071QgPV3CIgXPk+1f7gOeA1PeVcZo+2dbatKrzGerERk",
            'val' => False
        ],
        
        /*
         * Session Handler Configuration.
         *
         * Since by default we use phpseclib's AES Cryptographic Key
         * for use in the SessionHandler class for encryption, please
         * refer to the official phpseclib documentation for further
         * explanation of the parameter password, or others such
         * as Iv or key.
         */
        'handler' => [
            
            // The Initialization Vector.
            'iv' => base64_decode( "1hlwJc9EnfgGkrMRNm4ejA==" ),
            
            // The Key.
            'key' => Null,//base64_decode( "URwhEmeJY1P8Zse8Sk0mLbVBuFizwCwvR6b4uzmrhMY=" ),
            
            // Password Parameters.
            'password' => [
                
                // AES Hash Password.
                "yumeSessionPassword",
                
                // AES Hash Method.
                "pbkdf2",
                
                // AES Hash Type.
                "sha512",
                
                // AES Hash Salt.
                "yumeSessionSalt",
                
                // The Iteration Count.
                1000,
                
                // Derived Key Length.
                Yume\Kama\Obi\Security\Symmetric\AES::chiper()->getKeyLength() >> 3
                
            ],
            
            'driver' => Yume\Kama\Obi\HTTP\Session\SessionHandler::class
        ]
    ],
    
    /*
     * Server configuration.
     *
     * You can freely define the host or port for
     * your server, but at the moment Yume doesn't
     * support more server configuration capabilities,
     * but we might add it someday.
     *
     */
    'server' => [
        'host' => "127.0.0.1",
        'port' => 8026
    ],
    
    /*
     * Authentication configuration.
     *
     * ....
     */
    'authentication' => [
        'cookie' => [
            'allow' => True,
            'index' => [
                "c.auth.user",
                "c.auth.pass"
            ]
        ],
        'session' => [
            'allow' => True,
            'index' => [
                "s.auth.user",
                "s.auth.pass"
            ]
        ]
    ],
    
    'response' => [
        
        /*
         * Http code response collection.
         *
         * When you are surprised by a user accessing an
         * undefined page on your route but you don't bother
         * to write HTTP Raw to the header, with this
         * configuration you don't have to bother writing
         * HTTP Raw response code anymore.
         *
         * @example [HTTP\Response\Response::code( Int $code, ? String $message = Null )]
         */
        'code' => [
            
            /*
             * HTTP Response Code 1xx
             *
             * The codes in this category provide information that the
             * request from the browser is still being processed for some reason.
             * It's not just an error, really. Just as additional information to
             * let you know what's going on.
             */
            '1xx' => [
                100 => "Continue",
                101 => "Switching Protocols",
                103 => "Early Hints"
            ],
            
            /*
             * HTTP Response Code 2xx
             *
             * Code which means that the browser request has been
             * successfully received, understood, and processed by the server.
             * In other words, everything went smoothly.
             */
            '2xx' => [
                200 => "Everything is OK",
                201 => "Created",
                202 => "Accepted",
                203 => "Non-Authoritative Information",
                204 => "No Content",
                205 => "Reset Content",
                206 => "Partial Content"
            ],
            
            /*
             * HTTP Response Code 3xx
             *
             * ...
             */
            '3xx' => [
                
            ],
            
            /*
             * HTTP Response Code 4xx
             *
             * Code in this category indicates an error from the web browser.
             * Either from the web browser itself or from a browser request.
             */
            '4xx' => [
                400 => "Bad Request",
                401 => "Unauthorized",
                402 => "Payment Required",
                403 => "Access to that resource is forbidden",
                404 => "The requested resource was not found",
                405 => "Method not allowed",
                406 => "Not acceptable response",
                407 => "Proxy Authentication Required",
                408 => "The server timed out waiting for the rest of the request from the browser",
                409 => "Conflict",
                410 => "The requested resource is gone and won’t be coming back",
                411 => "Length Required",
                412 => "Precondition Failed",
                413 => "Request Entity Too Large",
                414 => "URL Too Long",
                415 => "Unsupported Media Type",
                416 => "Range Not Satisfiable",
                417 => "Expectation Failed",
                418 => "I’m a teapot",
                422 => "Unprocessable Entity",
                425 => "Too Early",
                426 => "Upgrade Required",
                428 => "Precondition Required",
                429 => "Too many requests",
                431 => "Request Header Fields Too Large",
                451 => "Unavailable for Legal Reasons",
                499 => "Client closed request"
            ],
            
            /*
             * HTTP Response Code 5xx
             *
             * This indicates an error from the server.
             * So that HTTP response code errors of this
             * category are more difficult to fix because
             * of problems on the server.
             */
            '5xx' => [
                500 => "There was an error on the server and the request could not be completed",
                501 => "Not Implemented",
                502 => "Bad Gateway",
                503 => "The server is unavailable to handle this request right now",
                504 => "The server, acting as a gateway, timed out waiting for another server to respond",
                505 => "HTTP Version Not Supported",
                511 => "Network Authentication Required",
                521 => "Web server is down"
            ],
            
            /*
             * HTTP Response Code 6xx
             *
             * This response code is for the Yume framework only.
             */
            '6xx' => [
                616 => "Invalid Response Code"
            ]
            
        ],
        
        /*
         * Response content type collection.
         *
         * Here you can freely add any type of
         * content according to the needs of your
         * application, here I have also provided
         * it for default support.
         *
         * @example [HTTP\Response\Response::type( String $cType )]
         */
        'type' => [
            'aac' => [
                'Content-Type' => "audio/aac"
            ],
            'abw' => [
                'Content-Type' => "application/x-abiword"
            ],
            'arc' => [
                'Content-Type' => "application/x-freearc"
            ],
            'avif' => [
                'Content-Type' => "image/avif"
            ],
            'avi' => [
                'Content-Type' => "video/x-msvideo"
            ],
            'azw' => [
                'Content-Type' => "application/vnd.amazon.ebook"
            ],
            'bin' => [
                'Content-Type' => "application/octet-stream"
            ],
            'bmp' => [
                'Content-Type' => "image/bmp"
            ],
            'bz' => [
                'Content-Type' => "application/x-bzip"
            ],
            'bz2' => [
                'Content-Type' => "application/x-bzip2"
            ],
            'cda' => [
                'Content-Type' => "application/x-cdf"
            ],
            'csh' => [
                'Content-Type' => "application/x-csh"
            ],
            'css' => [
                'Content-Type' => "text/css"
            ],
            'csv' => [
                'Content-Type' => "text/csv"
            ],
            'doc' => [
                'Content-Type' => "application/msword"
            ],
            'docx' => [
                'Content-Type' => "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            ],
            'eot' => [
                'Content-Type' => "application/vnd.ms-fontobject"
            ],
            'epub' => [
                'Content-Type' => "application/epub+zip"
            ],
            'gz' => [
                'Content-Type' => "application/gzip"
            ],
            'gif' => [
                'Content-Type' => "image/gif"
            ],
            'htm' => [
                'Content-Type' => "text/html"
            ],
            'html' => [
                'Content-Type' => "text/html"
            ],
            'ico' => [
                'Content-Type' => "image/vnd.microsoft.icon"
            ],
            'ics' => [
                'Content-Type' => "text/calendar"
            ],
            'jar' => [
                'Content-Type' => "application/java-archive"
            ],
            'jpg' => [
                'Content-Type' => "image/jpeg"
            ],
            'jpeg' => [
                'Content-Type' => "image/jpeg"
            ],
            'js' => [
                'Content-Type' => "text/javascript"
            ],
            'json' => [
                'Content-Type' => "application/json;charset=utf-8"
            ],
            'jsonld' => [
                'Content-Type' => "application/ld+json"
            ],
            'mid' => [
                'Content-Type' => "audio/midi"
            ],
            'midi' => [
                'Content-Type' => "audio/x-midi"
            ],
            'mjs' => [
                'Content-Type' => "text/javascript"
            ],
            'mp3' => [
                'Content-Type' => "audio/mpeg"
            ],
            'mp4' => [
                'Content-Type' => "video/mp4"
            ],
            'mpeg' => [
                'Content-Type' => "video/mpeg"
            ],
            'mpkg' => [
                'Content-Type' => "application/vnd.apple.installer+xml"
            ],
            'odp' => [
                'Content-Type' => "application/vnd.oasis.opendocument.presentation"
            ],
            'ods' => [
                'Content-Type' => "application/vnd.oasis.opendocument.spreadsheet"
            ],
            'odt' => [
                'Content-Type' => "application/vnd.oasis.opendocument.text"
            ],
            'oga' => [
                'Content-Type' => "audio/ogg"
            ],
            'ogv' => [
                'Content-Type' => "video/ogg"
            ],
            'ogx' => [
                'Content-Type' => "application/ogg"
            ],
            'opus' => [
                'Content-Type' => "audio/opus"
            ],
            'otf' => [
                'Content-Type' => "font/otf"
            ],
            'png' => [
                'Content-Type' => "image/png"
            ],
            'pdf' => [
                'Content-Type' => "application/pdf"
            ],
            'php' => [
                'Content-Type' => "application/x-httpd-php"
            ],
            'ppt' => [
                'Content-Type' => "application/vnd.ms-powerpoint"
            ],
            'pptx' => [
                'Content-Type' => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            ],
            'rar' => [
                'Content-Type' => "application/vnd.rar"
            ],
            'rtf' => [
                'Content-Type' => "application/rtf"
            ],
            'sh' => [
                'Content-Type' => "application/x-sh"
            ],
            'svg' => [
                'Content-Type' => "image/svg+xml"
            ],
            'swf' => [
                'Content-Type' => "application/x-shockwave-flash"
            ],
            'tar' => [
                'Content-Type' => "application/x-tar"
            ],
            'tif' => [
                'Content-Type' => "image/tiff"
            ],
            'tiff' => [
                'Content-Type' => "image/tiff"
            ],
            'ts' => [
                'Content-Type' => "video/mp2t"
            ],
            'ttf' => [
                'Content-Type' => "font/ttf"
            ],
            'txt' => [
                'Content-Type' => "text/plain"
            ],
            'vsd' => [
                'Content-Type' => "application/vnd.visio"
            ],
            'wav' => [
                'Content-Type' => "audio/wav"
            ],
            'weba' => [
                'Content-Type' => "audio/webm"
            ],
            'webm' => [
                'Content-Type' => "video/webm"
            ],
            'webp' => [
                'Content-Type' => "image/webp"
            ],
            'woff'  => [
                'Content-Type' => "font/woff"
            ],
            'woff2' => [
                'Content-Type' => "font/woff2"
            ],
            'xhtml' => [
                'Content-Type' => "application/xhtml+xml"
            ],
            'xls' => [
                'Content-Type' => "application/vnd.ms-excel"
            ],
            'xlsx' => [
                'Content-Type' => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            ],
            'xml' => [
                'Content-Type' => "application/xml"
            ],
            'xul' => [
                'Content-Type' => "application/vnd.mozilla.xul+xml"
            ],
            'zip' => [
                'Content-Type' => "application/zip"
            ],
            '3gp' => [
                'Content-Type' => "audio/video",
            ],
            '3g2' => [
                'Content-Type' => "audio/video",
            ]
        ]
        
    ]
    
];

?>