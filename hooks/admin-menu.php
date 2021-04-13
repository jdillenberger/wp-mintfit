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
        __('Options', 'mintfit'),
        __('Options', 'mintfit'),
        'mintfit_change_options',
        'mintfit',
        function () {
            do_action('mintfit-admin-change-options-page');
        },
        11
    );

    add_submenu_page(
        'mintfit',
        __('Results', 'mintfit'),
        __('Results', 'mintfit'),
        'mintfit_view_results',
        'mintfit_view_results',
        function () {
            do_action('mintfit-admin-view-results-page');
        },
        11
    );



});
