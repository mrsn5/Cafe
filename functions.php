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

//add bootstrap
function add_bootstrap(){
    wp_enqueue_style( 'bootstrap', get_stylesheet_directory_uri() . '/libs/bootstrap-3.3.7-dist/css/bootstrap.css', array(), 20141119 );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/libs/bootstrap-3.3.7-dist/js/bootstrap.min.js', array('jquery'), '20120206', true );
}
add_action('wp_enqueue_scripts', 'add_bootstrap');

//add less
function main_less() {
    ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.3/less.min.js" type="text/javascript"></script>
    <?php
}
add_action( 'wp_footer' , 'main_less' );

function load_my_scripts(){
    if(is_page()) {
        global $wp_query;

        $template_name = get_post_meta($wp_query->post->ID, '_wp_page_template', true);

        switch ($template_name)
        {
            case 'menu.php':
                wp_enqueue_script('menu-ajax-script', get_template_directory_uri() . '/js/compiled/menu.js', array('jquery'));
                wp_localize_script('menu-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'),
                        'category_page_url' => get_permalink(get_page_by_title( 'Category' ))));
                break;
            case 'category.php':
                wp_enqueue_script('category-ajax-script', get_template_directory_uri() . '/js/compiled/category.js', array('jquery'));
                wp_localize_script('category-ajax-script', 'url_object',
                    array('ajax_url' => admin_url('admin-ajax.php'), 'template_directory' => get_stylesheet_directory_uri()));
                break;
            case 'deliverer.php':
                wp_enqueue_script('deliverer-ajax-script', get_template_directory_uri() . '/js/compiled/deliverer.js', array('jquery'));
                wp_localize_script('deliverer-ajax-script', 'ajax_object',
                    array('ajax_url' => admin_url('admin-ajax.php')));
                break;
            case 'personnel.php':
                wp_enqueue_script('personnel-ajax-script', get_template_directory_uri() . '/js/compiled/personnel.js', array('jquery'), 100);
                wp_localize_script('personnel-ajax-script', 'ajax_object',
                    array('ajax_url' => admin_url('admin-ajax.php')));
                break;
        }
    }

    wp_enqueue_script( 'general_js_functions', get_template_directory_uri() . '/js/general_functions.js', array('jquery'));
}

add_action( 'wp_enqueue_scripts', 'load_my_scripts' );
?>