<?php

add_filter('mintfit-rest-get-options', function ($atts) {

    return [
        'client_id' => get_option( 'mintfit-api-client-id', '' ),
        'client_secret' => get_option( 'mintfit-api-client-secret', '' ),
        'tests_available' => json_decode(get_option('mintfit-api-tests-available', '[]'), true),
        'tests_active' => json_decode(get_option('mintfit-api-tests-active', '[]'), true)
    ];

});