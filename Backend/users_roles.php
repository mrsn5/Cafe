<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 04.04.2019
 * Time: 23:55
 */


// ADDING NEW USERS ROLES
remove_role( 'editor' );
remove_role( 'author' );
remove_role( 'contributor' );
remove_role( 'subscriber' );
add_role( 'waiter', ('Офіціант' ), array( ) );
add_role( 'cook', ('Кухар' ), array( ) );
add_role( 'bookkeeper', ('Бухгалтер' ), array( ) );
add_role( 'barman', ('Бармен' ), array( ) );
add_role( 'owner', ('Власник' ), array( ) );
add_role( 'chef', ('Шуф-кухар' ), array( ) );
add_role( 'worker', ('Робітник' ), array( ) );


add_action( 'wp_ajax_get_user_role', 'get_user_role' );
add_action( 'wp_ajax_nopriv_get_user_role', 'get_user_role' );

function get_user_role(){
    $user_role = null;
    if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $roles = ( array )$user->roles;
        echo json_encode($roles, JSON_UNESCAPED_UNICODE);
        die();
//        if(count($roles) > 0){
//            $user_role = $roles[0];
//            echo ($user_role);
//
//        }
    }
}


