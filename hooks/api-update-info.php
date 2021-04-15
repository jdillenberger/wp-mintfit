<?php

/**
 * HOOK TO UPDATE MINTFIT DATA
 *
 * Invoking this hook will update the local database using the mintfit-api
 */

$client_id = get_option( 'mintfit-api-client-id', '' );
$client_secret = get_option( 'mintfit-api-client-secret', '' );

add_action( 'update-mintfit-api-info', function() use ($client_id, $client_secret){

    // Return if the client_id or client_secret are not set
    if ($client_id === '' || $client_secret === '') return;

    $api_url = "https://api.mintfit.hamburg/v1/partner/get/$client_id/$client_secret/info";

    $mintfit_api_info = json_decode(file_get_contents($api_url), true);

    if (is_array($mintfit_api_info) && count($mintfit_api_info) > 0) {
        add_option('mintfit-api-tests-active', json_encode($mintfit_api_info['tests']));
        update_option('mintfit-api-tests-available', json_encode($mintfit_api_info['tests']));
    }

});

// Run instantly if no tests are available 
if ($client_id !== '' || $client_secret !== '') {
    $tests_available = json_decode(get_option('mintfit-api-tests-available', '[]'), true);

    if (is_array($tests_available) && count($tests_available) == 0) {
        do_action('update-mintfit-api-info');
    }
}