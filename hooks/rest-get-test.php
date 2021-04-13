<?php

add_filter('mintfit-rest-get-test', function ($atts) {
    
    $get_trash = $_GET['trash'] ?? false;
    $get_all_users = $_GET['all_users'] ?? false;

    // Abort if a non-authorized user wants to access data for all users
    if ($get_all_users && !current_user_can('mintfit_view_results')) {
        return [];
    }

    // Abort if the requested test does not exist
    if (!in_array($atts['test'],  array_merge( json_decode(get_option('mintfit-api-tests', '[]'), true), ['all'] ))){
        return [];
    }
    
    $conditions = [];
    $condition_variables = [];

    if (!$get_all_users) {
        array_push($conditions, "`user_id` = %d");
        array_push($condition_variables,  get_current_user_id());
    }

    if ($atts['test'] != 'all') {
        array_push($conditions, "`test_slug` = %s");
        array_push($condition_variables, $atts['test']);
    }

    if (!$get_trash) {
        array_push($conditions, "`trash` IS NOT TRUE");
    } else {
        array_push($conditions, "`trash` IS TRUE");
    }

    global $wpdb;
    $mf_table = $wpdb->prefix . 'mintfit';
    $query = "SELECT * FROM $mf_table WHERE " . implode(' AND ', $conditions);
    
    $wpdb->show_errors();
    $stmt = call_user_func_array([$wpdb, 'prepare'], array_merge([$query], $condition_variables));

    return array_map(function($test_result){

        return [
            'test_slug' => $test_result['test_slug'],
            'max_score' => floatval($test_result['max_score']),
            'score' => floatval($test_result['score']),
            'start_time' => $test_result['start_time'],
            'end_time' => $test_result['end_time'],
            'finished' => boolval($test_result['finished']),
            'question_scores' => array_map(function($score){
                return $score;
            }, json_decode($test_result['data'], true))
        ];

    }, $wpdb->get_results($stmt, ARRAY_A));

});