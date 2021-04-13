<?php

add_filter('mintfit-rest-put-api-update', function ($atts) {

    do_action( 'update_mintfit_api' );
    return true;

});