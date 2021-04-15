<?php
/**
 * Schedules updating the MintFIT api
 */
if ( ! wp_next_scheduled( 'update_mintfit_api' ) ) {

    add_filter( 'cron_schedules', function($schedules){

        $schedules['update_mintfit_schedule'] = [
            'interval' => 300,
            'display' => __('Every 5 minutes')
        ];

        return $schedules;
    }); 

    wp_schedule_event( time(), 'update_mintfit_schedule', 'update_mintfit_api' );

}

if ( ! wp_next_scheduled( 'update-mintfit-api-info' ) ) {

    wp_schedule_event( time(), 'daily', 'update-mintfit-api-info' );

}
