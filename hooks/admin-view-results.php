<?php

add_action('mintfit-admin-view-results-page', function(){

    wp_enqueue_script('mintfit-admin-options-js', plugin_dir_url(MF_PLUGIN_INDEX) . 'jsdist/main.js', [], false, true);
    
    wp_localize_script('mintfit-admin-options-js', 'localURLs', [
        'home' => home_url(),
        'rest' => rest_url(),
        'gravityscores' => plugin_dir_url(MF_PLUGIN_INDEX),
    ]);

    wp_localize_script('mintfit-admin-options-js', 'nonce', [wp_create_nonce('wp_rest')]);

    wp_localize_script('mintfit-admin-options-js', 'position', ['admin', 'viewResults']);

    ?>
    <div class="mitfit-app wrap">
        <admin-view-results :test-results="testResults" @deleteenty="deleteEntry($event)"/>
    </div>
    <?php

});