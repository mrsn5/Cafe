<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 15.03.2019
 * Time: 13:50
 */

require_once 'Backend/personnel_ajax.php';

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
    wp_enqueue_script( 'general_js_functions', get_template_directory_uri() . '/js/general_functions.js', array('jquery'));

    wp_enqueue_script( 'personnel-ajax-script', get_template_directory_uri() . '/js/compiled/personnel.js', array('jquery'), 100);

    wp_localize_script( 'personnel-ajax-script', 'ajax_object',
            array( 'ajax_url' => admin_url('admin-ajax.php' )));
}

add_action( 'wp_enqueue_scripts', 'load_my_scripts' );
?>