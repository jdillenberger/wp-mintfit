<?php

add_action('mintfit-admin-change-options-page', function(){

    wp_enqueue_script('mintfit-admin-options-js', plugin_dir_url(MF_PLUGIN_INDEX) . 'jsdist/main.js', [], false, true);
    
    wp_localize_script('mintfit-admin-options-js', 'localURLs', [
        'home' => home_url(),
        'rest' => rest_url(),
        'mintfitPluginDir' => plugin_dir_url(MF_PLUGIN_INDEX)
    ]);

    wp_localize_script('mintfit-admin-options-js', 'nonce', [wp_create_nonce('wp_rest')]);

    wp_localize_script('mintfit-admin-options-js', 'position', ['admin', 'options']);

    ?>
    <div class="mitfit-app wrap">
        <admin-change-options 
            :client-id="clientId" 
            :client-secret="clientSecret"
            :tests-active="testsActive"
            :tests-available="testsAvailable"
            @saveoptions="saveOptions($event)"
        />
    </div>
    <?php

});
