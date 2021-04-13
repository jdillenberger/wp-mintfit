<?php

add_filter('mintfit-rest-get-test', function ($atts) {
    
    
    if (!in_array($atts['test'],  array_merge( json_decode(get_option('mintfit-api-tests', '[]'), true), ['all'] ))){
        return [];
    }
    
    global $wpdb;
    $mf_table = $wpdb->prefix . 'mintfit';
    
    if($atts['test'] == 'all') {
        $query = "SELECT * FROM $mf_table WHERE `user_id` = %d AND `trash` IS NOT TRUE";
        $stmt = $wpdb->prepare($query, get_current_user_id());
    } else {
        $query = "SELECT * FROM $mf_table WHERE `user_id` = %d AND `test_slug` = %s AND `trash` IS NOT TRUE";
        $stmt = $wpdb->prepare($query, get_current_user_id(), $atts['test']);
    }
    
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