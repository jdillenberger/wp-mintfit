<?php

register_activation_hook(MF_PLUGIN_INDEX, function () {

    $capabilities = ['mintfit_change_options', 'mintfit_view_results'];

    // Setup user capabilities
    foreach ($GLOBALS['wp_roles']->role_objects as $role) {
        foreach ($capabilities as $capability) {
            if ($role->has_cap($capability)) {
                continue;
            }
        
            $role->add_cap($capability, $role->has_cap('manage_options'));
        }
    }

    // Setup database
    global $wpdb;

    $mf_table = $wpdb->prefix . 'mintfit';
    

    $wpdb->query("CREATE TABLE IF NOT EXISTS `$mf_table` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT NOT NULL,
        `test_slug` VARCHAR(127) NOT NULL,
        `max_score` FLOAT NOT NULL,
        `score` FLOAT NOT NULL,
        `start_time` TIMESTAMP,
        `end_time` TIMESTAMP,
        `data` TEXT,
        `hash` VARCHAR(255),
        `finished` BOOLEAN,
        `trash` BOOLEAN
    )");

});

register_deactivation_hook(MF_PLUGIN_INDEX, function () {
    include plugin_dir_path(MF_PLUGIN_INDEX) . 'uninstall.php';
});
