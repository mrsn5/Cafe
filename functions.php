<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 15.03.2019
 * Time: 13:50
 */

require_once 'Backend/personnel_ajax.php';
require_once 'Backend/deliverer_ajax.php';
require_once 'Backend/menu_ajax.php';
require_once 'Backend/category_ajax.php';
require_once 'Backend/statistics_ajax.php';
require_once 'Backend/orders_ajax.php';
require_once 'Backend/deliveries_ajax.php';
require_once 'Backend/storage_ajax.php';

//add bootstrap
function add_bootstrap(){
    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/libs/bootstrap-3.3.7-dist/css/bootstrap.css', array(), 20141119 );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js', array('jquery'), '20120206', true );
}
add_action('wp_enqueue_scripts', 'add_bootstrap');

//add less
function main_less() {
    wp_enqueue_script( 'less', 'https://cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js');
}

add_action('wp_enqueue_scripts', 'main_less');


////add d3
//function d3_functions(){
//    global $wp_query;
//    $template_name = get_post_meta($wp_query->post->ID, '_wp_page_template', true);
//
//    if($template_name == 'statistics.php')
//        wp_enqueue_script( 'd3', 'http://d3js.org/d3.v3.min.js', array('jquery'));
//}
//
//add_action( 'wp_head' , 'd3_functions');

function load_my_scripts(){
    if(is_page()) {
        global $wp_query;

        $template_name = get_post_meta($wp_query->post->ID, '_wp_page_template', true);

        switch ($template_name)
        {
            case 'statistics.php':
                wp_enqueue_script( 'd3', 'http://d3js.org/d3.v3.min.js', array('jquery'));

                wp_enqueue_script( 'graphics_js', get_template_directory_uri() . '/js/graphics.js', array('jquery'), '1.0.0', true);

                wp_enqueue_script('statistics-ajax-script', get_template_directory_uri() . '/js/compiled/statistics.js', array('jquery'), '1.0.0', true);
                wp_localize_script('statistics-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php')));
                break;
            case 'menu.php':
                wp_enqueue_script('menu-ajax-script', get_template_directory_uri() . '/js/compiled/menu.js', array('jquery'), '1.0.0', true);
                wp_localize_script('menu-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'),
                        'category_page_url' => get_permalink(get_page_by_title( 'Category' )), 'template_directory' => get_stylesheet_directory_uri()));
                break;
            case 'category.php':
                wp_enqueue_script('category-ajax-script', get_template_directory_uri() . '/js/compiled/category.js', array('jquery'), '1.0.0', true);
                wp_localize_script('category-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'), 'template_directory' => get_stylesheet_directory_uri()));
                break;
            case 'deliverer.php':
                wp_enqueue_script('deliverer-ajax-script', get_template_directory_uri() . '/js/compiled/deliverer.js', array('jquery'), '1.0.0', true);
                wp_localize_script('deliverer-ajax-script', 'ajax_object',
                    array('ajax_url' => admin_url('admin-ajax.php')));
                break;
            case 'personnel.php':
                wp_enqueue_script('personnel-ajax-script', get_template_directory_uri() . '/js/compiled/personnel.js', array('jquery'), '1.0.0', true);
                wp_localize_script('personnel-ajax-script', 'ajax_object',
                    array('ajax_url' => admin_url('admin-ajax.php')));
                break;
            case 'history.php':
                wp_enqueue_script('orders-ajax-script', get_template_directory_uri() . '/js/compiled/history.js', array('jquery'), '1.0.0', true);
                wp_localize_script('orders-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'),'template_directory' => get_stylesheet_directory_uri()));
                break;
            case 'orders_page.php':
                wp_enqueue_script('orders-ajax-script', get_template_directory_uri() . '/js/compiled/orders.js', array('jquery'), '1.0.0', true);
                wp_localize_script('orders-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'),'template_directory' => get_stylesheet_directory_uri()));
                break;
            case 'deliveries.php':
                wp_enqueue_script('deliveries-ajax-script', get_template_directory_uri() . '/js/compiled/deliveries.js', array('jquery'), '1.0.0', true);
                wp_localize_script('deliveries-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'),'template_directory' => get_stylesheet_directory_uri()));
                break;
        }
    }
    wp_enqueue_script( 'general_js_functions', get_template_directory_uri() . '/js/general_functions.js', array('jquery'));
}

add_action( 'wp_enqueue_scripts', 'load_my_scripts' );
?>