<?php

add_filter('mintfit-rest-get-options', function ($atts) {

    //update_option('mintfit-api-tests', '[]');
    return [
        'client_id' => get_option( 'mintfit-api-client-id', '' ),
        'client_secret' => get_option( 'mintfit-api-client-secret', '' ),
        'tests' => json_decode(get_option('mintfit-api-tests', '[]'), true)
    ];

});