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



