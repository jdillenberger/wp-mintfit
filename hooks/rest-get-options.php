<?php

add_filter('mintfit-rest-get-options', function ($atts) {

    return [
        'client_id' => get_option( 'mintfit-api-client-id', '' ),
        'client_secret' => get_option( 'mintfit-api-client-secret', '' ),
        'tests' => json_decode(get_option('mintfit-api-tests', '[]'), true)
    ];

});