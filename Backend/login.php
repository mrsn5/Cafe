<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 04.04.2019
 * Time: 23:56
 */

function loginLogo() {
    echo '<style type="text/css">
        h1 a {display:none !important; }
    </style>';
}

add_action('login_head', 'loginLogo');


function headerSearch() {
    echo '<style type="text/css">
            #adminbarsearch, #wp-admin-bar-wp-logo, #wp-admin-bar-customize, #wp-admin-bar-comments, #wp-admin-bar-new-post, 
            #wp-admin-bar-new-page, #wp-admin-bar-new-media, #wp-admin-bar-dashboard, #wp-admin-bar-appearance, #wp-admin-bar-edit { 
                display: none !important; 
            }
            #wp-admin-bar-site-name .ab-sub-wrapper{ 
                display: none !important; 
            }
           
          </style>';
}

add_action('wp_head', 'headerSearch');


add_action('template_redirect', 'loginRedirect');
function loginRedirect(){
    if(!is_user_logged_in()) {
        wp_redirect( get_site_url(). '/wp-login', 302);
        exit;
    }
}

function admin_default_page() {
    return get_site_url();
}

add_filter('login_redirect', 'admin_default_page');