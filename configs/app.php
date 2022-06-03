<?php

use function Yume\Func\tree;

use phpseclib3\Crypt;

return [

    /*
     * Your Application Name.
     * 
     * @values String
     */
    'name' => "Octancle",
    
    /*
     * Author Info.
     *
     * @values Array
     */
    'author' => [
        'name' => "hxAri",
        'mail' => "ari160824@gmail.com"
    ],
    
    'cache' => [
        
        /*
         * The location where the entire cache will be stored.
         *
         * @values String
         */
        'path' => "/storage/noteware/cache",
        
        /*
         * Prefix name for each cache file.
         *
         * @values String
         */
        'prefix' => "yume",
        
        /*
         * Default value cache expired Timestamp.
         *
         * @values String
         */
        'expired' => "+7 days"
        
    ],
    
    'error' => [
        'handler' => [
            'trigger' => "Yume\Kama\Obi\Error\ErrorTrigger::handler",
            'exception' => "Yume\Kama\Obi\Error\ErrorTracer::handler"
        ],
        'tracer' => [
            
            /*
             * Allow to handle exception.
             *
             * @values Bool
             */
            'allow' => True,
            
            /*
             * Tracer Driver class name.
             *
             * @values String
             */
            'driver' => Yume\Kama\Obi\Exception\PSTrace\PSTraceProvider::class,
            
            /*
             * The stack traces you want to display.
             *
             * @values Array
             */
            'traces' => [
                "@Object" => [
                    "@Code",
                    "@Type",
                    "@Alias",
                    "@Class",
                    "@Trait",
                    "@Parent",
                    "@Interface",
                    "@Previous"
                ],
                "@File" => [
                    "@Line",
                    "@File"
                ],
                "@Message",
                "@Trace"
            ]
        ],
        
    ],
    
    'loader' => [
        
        /*
         * Allow to save the filename as well
         * as the class when it loads successfully.
         *
         * I don't recommend using this on your host/server
         * Side because, it will take a lot of time to validate
         * The correct namespace according to the directory where
         * The file is stored.
         *
         * @values Bool
         */
        'save' => True,False,
        'spaces' => [
            \Yume\Kama\Obi::class => [
                "path" => UTIL_PATH,
                "tree" => Yume\Kama\Obi\IO\Dir\Dir::tree( UTIL_PATH, False )
            ],
            \App::class => [
                "path" => APP_PATH,
                "tree" => Yume\Kama\Obi\IO\Dir\Dir::tree( APP_PATH, False )
            ]
        ]
        
    ],
    
    'locale' => [
        
        /*
         * Your country name.
         * This is not mandatory!
         *
         * @values String
         */
        'country' => "Indonesian",
        
        /*
         * Your country code.
         *
         * @values String
         */
        'language' => "ID",
        
        /*
         * Your country Time Zone
         *
         * @values String
         */
        'timezone' => "Asia/Jakarta"
        
    ]
    
];

?>