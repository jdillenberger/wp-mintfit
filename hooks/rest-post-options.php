<?php

add_filter('mintfit-rest-post-options', function ($atts) {

    $data = $atts->get_params();

    $old_tests = get_option('mintfit-api-tests', []);
    $old_client_id = get_option( 'mintfit-api-client-id', '' );
    $old_client_secret = get_option( 'mintfit-api-client-secret', '' );

    

    update_option('mintfit-api-tests', json_encode($data['tests']) );
    update_option('mintfit-api-client-id', $data['clientId']);
    update_option('mintfit-api-client-secret', $data['clientSecret']);

    if (is_array($data['tests'])) {
        update_option('mintfit-api-tests', json_encode($data['tests']));
    }

    

    return [
        'old_client_id' => $old_client_id,
        'old_client_secret' => $old_client_secret,
        'old_tests' =>  $old_tests,
        'new_client_id' => $data['clientId'],
        'new_client_secret' => $data['clientSecret'],
        'new_tests' => $data['tests']
    ];

});