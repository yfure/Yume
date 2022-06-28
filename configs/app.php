<?php

return([
    
    /*
     * Environment class configuration.
     *
     */
    "environment" => [
        
        /*
         * The location where the environment files are stored.
         *
         * You can rename files and move environment
         * files where no one can reach them.
         *
         * @path Default BASE_PATH
         */
        "path" => "kankyou"
    ],
    
    "http" => [
        "cookies" => [
            "handler" => Yume\Kama\Obi\HTTP\Cookies\CookieHeader::class
        ],
        "session" => [
            
            /*
             * Securing Session INI Settings
             *
             * By securing session related INI settings, developers can improve session security.
             * Some important INI settings do not have any recommended settings. Developers are
             * responsible for hardening session settings.
             */
            "configs" => [
                "session.cookie_domain" => "",
                "session.cookie_httponly" => 1,
                "session.cookie_lifetime" => 0,
                "session.cookie_path" => "/",
                "session.cookie_samesite" => "Strict",
                "session.cookie_secure" => 1,
                "session.gc_maxlifetime" => 1440,
                "session.name" => "YUMESESSID",
                "session.sid_length" => 48,
                "session.sid_bits_per_character" => 6,
                //"session.save_path" => "/",
                "session.save_handler" => "files",
                "session.use_cookies" => 1,
                "session.use_only_cookies" => 1,
                "session.use_strict_mode" => 1,
                "session.use_trans_sid" => 0
            ],
            
            /*
             * Session Handler Class
             *
             * SessionHandler is a special class that can be used to expose
             * the current internal PHP session save handler by inheritance.
             */
            "handler" => Yume\Kama\Obi\HTTP\Session\SessionHandler::class
        ]
    ],
    
    /*
     * Reflection class configuration.
     *
     */
    "reflector" => [
        "function" => [
            "template" => []
        ],
        "instance" => [
            "@method" => [
                "filter" => ReflectionMethod::IS_PUBLIC,
                "scheme" => []
            ],
            "@constant" => [
                "filter" => True,
                "scheme" => []
            ],
            "@property" => [
                "filter" => True,
                "scheme" => []
            ],
            "scheme" => [
                "class" => [
                    "name",
                    "space"
                ],
                "object" => [
                    "is" => [
                        "is::Abstract",
                        "is::Anonymous",
                        "is::Cloneable",
                        "is::Countable",
                        "is::Data",
                        "is::Enum",
                        "is::Final",
                        "is::Instance",
                        "is::Instantiable",
                        "is::Interface",
                        "is::Internal",
                        "is::Iterable",
                        "is::Stringable",
                        "is::SubclassOf",
                        "is::Throwable",
                        "is::Trait",
                        "is::UserDefined"
                    ]
                ],
                "traits" => "traits",
                "methods" => "methods",
                "constants" => "constants",
                "interfaces" => "interfaces",
                "properties" => "properties"
            ]
        ],
        "interface" => [
            "scheme" => []
        ],
        "parameter" => [
            "scheme" => []
        ]
    ],
    
    /*
     * Default Time Zone for app.
     *
     * Please visit the official PHP page for a full list of supported Time Zones.
     *
     * @webpage https://www.php.net/manual/en/timezones.php
     *
     * @default Asia/Tokyo
     */
    "timezone" => "Asia/Tokyo",
    
    /*
     * The Trouble configuration.
     *
     * It also includes the name of the function that handles the error,
     * where the error log is stored and also includes how the function
     * displays error messages based on a template or schema.
     */
    "trouble" => [
        "error" => [
            "scheme" => [
                "File" => [
                    "File",
                    "Line"
                ],
                "Error" => [
                    "Code",
                    "Level"
                ],
                "Message"
            ],
            
            /*
             * Trigger Handler Function
             *
             * Function sets a user-defined error handler function.
             */
            "handler" => "Yume\Kama\Obi\Error\Toriga\Toriga::handler"
        ],
        "exception" => [
            
            /*
             * Note
             *
             * It is recommended to set the Trace value to False when the
             * application will be uploaded to the host, this is because
             * Trace will display program code traces, such as Argument
             * Values, Function|Class|File|Directory|Variable Names, etc
             * this will be very dangerous if the data is leaked.
             */
            "traces" => True,
            
            /*
             * The exception scheme that will be displayed, you can change
             * the order or even delete one of them at will and be careful.
             *
             */
            "scheme" => [
                "Object" => [
                    "Code",
                    "Type",
                    "Alias",
                    "Class",
                    "Trait",
                    "Parent",
                    "Interface",
                    "Previous"
                ],
                "File" => [
                    "Line",
                    "File"
                ],
                "Message",
                "Trace"
            ],
            
            /*
             * Exception Handler Function.
             *
             * PHP allows you to catch the uncaught exceptions
             * by registering a global exception handler. 
             */
            "handler" => "Yume\Kama\Obi\Error\Memew\Memew::handler"
        ]
    ]
    
]);

?>