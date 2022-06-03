<?php

(function() {
    // setup the URL and read the JS from a file
    $url = 'https://www.toptal.com/developers/javascript-minifier/raw';
    $js = file_get_contents( "/sdcard/project/personal/coding/Php/Octancle/storage/resource/script/apexcharts/dist/" );

    // init the request, set various options, and send it
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
        CURLOPT_POSTFIELDS => http_build_query([ "input" => $js ])
    ]);

    $minified = curl_exec($ch);

    // finally, close the request
    curl_close($ch);

    // output the $minified JavaScript
    echo $minified;
});

?>