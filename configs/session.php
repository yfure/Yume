<?php

/*
 * Configuration for Util Class Session.
 *
 * @values Array
 */
return [
    
    /*
     * Session Key & Val Encryption Password
     *
     * @values String
     */
    'encrypt' => [
        'key' => "953yjh3oWQjrc+071QgPV3CIgXPk+1f7gOeA1PeVcZo+2dbatKrzGerERk",
        'val' => False
    ],
    
    /*
     * Session Handler Configuration.
     *
     * @values String
     */
    'handler' => [
        
        // The Initialization Vector.
        'iv' => base64_decode( "1hlwJc9EnfgGkrMRNm4ejA==" ),
        
        // The Key.
        'key' => Null,//base64_decode( "URwhEmeJY1P8Zse8Sk0mLbVBuFizwCwvR6b4uzmrhMY=" ),
        
        /*
         * Password Parameters.
         *
         * @values Array
         */
        'password' => [
            
            /*
             * Handler AES Password
             *
             * @values String
             */
            "yumeSessionPassword",
            
            /*
             * Handler AES Method.
             *
             * @values String
             */
             "pbkdf2",
            
            /*
             * Handler AES Hash.
             *
             * @values String
             */
            "sha512",
            
            // Salt.
            "yumeSessionSalt",
            
            // The Iteration Count.
            1000,
            
            // Derived Key Length.
            Yume\Kama\Obi\Security\Symmetric\AES::chiper()->getKeyLength() >> 3
            
        ],
        
        /*
         * Session Storage Function.
         *
         * @values String
         */
        'driver' => Yume\Kama\Obi\HTTP\Session\SessionHandler::class
    ]
    
];

?>