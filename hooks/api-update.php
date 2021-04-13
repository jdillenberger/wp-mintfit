<?php

/**
 * HOOK TO UPDATE MINTFIT DATA
 *
 * Invoking this hook will update the local database using the mintfit-api
 */
add_action( 'update_mintfit_api', function(){

    $client_id = get_option( 'mintfit-api-client-id', '' );
    $client_secret = get_option( 'mintfit-api-client-secret', '' );
    
    // Return if the client_id or client_secret are not set
    if ($client_id === '' || $client_secret === '') return;

    global $wpdb;
    $mf_table = $wpdb->prefix . 'mintfit';
    $query = "INSERT INTO `$mf_table` 
                (`user_id`, `test_slug`, `max_score`, `score`, `start_time`, `end_time`, `data`, `hash`, `finished`, `trash`) 
            VALUES 
                (%d, %s, %f, %f, %s, %s, %s, %s, %d, false)";

    // Query MINTFIT-API for each registered test
    foreach(json_decode(get_option('mintfit-api-tests', '[]'), true) as $test_slug) {

        // TODO: ADD TIMESTAMP STUFF TO MAKE SURE NOT EVERYTHING IS LOADED EACH TIME
        $api_url = "https://api.mintfit.hamburg/v1/partner/get/$client_id/$client_secret/course/none/$test_slug";

        $test_results = json_decode(file_get_contents($api_url), true);
        
        // Use each response record and write its data to the database
        foreach ($test_results as $test_result) {

            $user = get_user_by('login', $test_result[1]);

            if (!$user) continue;

            $hash = sha1(json_encode($test_result));
            
            // Ignore record if it alreay exists
            if (intval($wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $mf_table WHERE `hash` = %s", $hash))) !== 0) continue;
            
            // Create an array for all single questions
            $question_scores = array_filter($test_result, function($v, $k){ return intval($k) >= 8; }, ARRAY_FILTER_USE_BOTH);
            $question_scores_clean = [];
            
            foreach($question_scores as $question_score) {
                if ($question_score == 'none') {
                    $question_score = null;
                } else {
                    $question_score = floatval($question_score);
                }

                array_push($question_scores_clean, $question_score);
            }    

            $wpdb->show_errors();

            // Write to Database
            $wpdb->query($wpdb->prepare($query, 
                $user->id, // user_id
                $test_slug,                                 // test_slug
                floatval( $test_result['7']),               // max_score
                floatval( $test_result['6']),               // score
                $test_result['3'],                          // start_time
                $test_result['4'],                          // end_time
                json_encode($question_scores_clean),        // data
                $test_result['2'] == 'finished',            // finished
                $hash
            ));

        }

    }

});
