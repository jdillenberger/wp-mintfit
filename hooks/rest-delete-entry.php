<?php

add_filter('mintfit-rest-delete-entry', function ($atts) {

    if (!current_user_can('mintfit_view_results')) {
        return false;
    }

    global $wpdb;

    $mf_table = $wpdb->prefix . 'mintfit';
    $stmt = $wpdb->prepare("UPDATE $mf_table SET `trash` = TRUE WHERE `id` = %d", $atts['id']);

    return $wpdb->query($stmt) != 0;

});