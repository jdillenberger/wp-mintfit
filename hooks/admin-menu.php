<?php

add_action('admin_menu', function () {

    // MINTIFIT main menu
    add_menu_page(
        __('Mintfit', 'mintfit'),
        __('Mintfit', 'mintfit'),
        'mintfit_change_options',
        'mintfit',
        function () {},
        'dashicons-text-page',
        17
    );


    add_submenu_page(
        'mintfit',
        __('MINTFIT Options', 'mintfit'),
        __('MINTFIT Options', 'mintfit'),
        'mintfit_change_options',
        'mintfit',
        function () {
            do_action('mintfit-admin-change-options-page');
        },
        11
    );



});
