<?php

return [
    Symmetric::class => [
        AES::class => [
            
            // Ctr ....
            'mode' => "ctr",
            
            // OpenSLL is a default Engine.
            'engine' => phpseclib3\Crypt\AES::ENGINE_OPENSSL,
            
            // Default key length.
            'keyLength' => 256,
            
            // Default IV size.
            'ivSize' => 16
            
        ]
    ]
];

?>