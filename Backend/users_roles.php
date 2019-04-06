<?php
/**
 * Created by PhpStorm.
 * User: San Nguyen
 * Date: 04.04.2019
 * Time: 23:55
 */

require_once 'dbhelper.php';

// ADDING NEW USERS ROLES
remove_role( 'editor' );
remove_role( 'author' );
remove_role( 'contributor' );
remove_role( 'subscriber' );
remove_role( 'worker' );
add_role( 'waiter', ('Офіціант' ), array( ) );
add_role( 'cook', ('Кухар' ), array( ) );
add_role( 'bookkeeper', ('Бухгалтер' ), array( ) );
add_role( 'barman', ('Бармен' ), array( ) );
add_role( 'owner', ('Власник' ), array( ) );
add_role( 'chef', ('Шуф-кухар' ), array( ) );


add_action( 'wp_ajax_get_user_role', 'get_user_role' );
add_action( 'wp_ajax_nopriv_get_user_role', 'get_user_role' );

add_action( 'wp_ajax_get_curr_user', 'get_curr_user' );
add_action( 'wp_ajax_nopriv_get_curr_user', 'get_curr_user' );

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
    die();
}

function get_curr_user(){
    if( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $tab_num = get_user_meta($user_id, 'tab_num', true);

        $conn = DBHelper::connect();

        try {
            $sqlQuery = "SELECT CONCAT(first_name, ' ', surname, ' ', COALESCE (father_name, '')) AS user_name, tab_num, position
                     FROM workers
                     WHERE tab_num = " . $tab_num . ";";

            $user = array();
            foreach ($conn->query($sqlQuery, PDO::FETCH_ASSOC) as $row) {
                $user = $row;
                break;
            }

            $curr_user = wp_get_current_user();
            $roles = ( array )$curr_user->roles;
            $user['user_role'] = $roles[0];

            echo json_encode($user, JSON_UNESCAPED_UNICODE);
            DBHelper::disconnect();
            die();

        }catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), "\n";
            echo $sqlQuery;
            DBHelper::disconnect();
            die();
        }
    }

    die();
}



add_action( 'user_new_form', 'crf_admin_registration_form' );
function crf_admin_registration_form( $operation ) {
    if ( 'add-new-user' !== $operation ) {
        // $operation may also be 'add-existing-user'
        return;
    }

    $tab_num = ! empty( $_POST['tab_num'] ) ? $_POST['tab_num'] : '';

    ?>


    <table class="form-table">
        <tr>
            <th><label for="tab_num"><?php esc_html_e( 'Табельний номер', 'crf' ); ?></label> <span style="color: red" class="description"><?php esc_html_e( '*', 'crf' ); ?></span></th>
            <td>
                <input type="text"
                       size="3"
                       id="tab_num"
                       name="tab_num"
                       value="<?php echo esc_attr( $tab_num ); ?>"
                       class="regular-text"
                />
            </td>
        </tr>
    </table>
    <?php
}



add_action( 'user_profile_update_errors', 'crf_user_profile_update_errors', 10, 3 );
function crf_user_profile_update_errors( $errors, $update, $user ) {
    if ( $update ) {
        return;
    }


    if ( empty( $_POST['tab_num'] ) ) {
        $errors->add( 'tab_num_error', __( '<strong>Помилка</strong>: Будь-ласка введіть табельний номер.', 'crf' ) );
    }


    global $wpdb;
    if ( ! empty( $_POST['tab_num'] ) && count((array)(($wpdb->get_results( "SELECT * FROM workers WHERE tab_num='$_POST[tab_num]'")))) == 0) {
        $errors->add( 'tab_num_error', __( '<strong>Помилка</strong>: Табельний номер не існує.', 'crf' ) );
    }
}


add_action( 'edit_user_created_user', 'crf_user_register' );
function crf_user_register( $user_id ) {
    if ( ! empty( $_POST['tab_num'] ) ) {
        update_user_meta( $user_id, 'tab_num', $_POST['tab_num']);
    }
}

add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
    ?>
    <table class="form-table">
        <tr>
            <th><label for="tab_num"><?php esc_html_e( 'Табельний номер', 'crf' ); ?></label></th>
            <td><?php echo esc_html( get_the_author_meta( 'tab_num',  $user->ID ) ); ?></td>
        </tr>
    </table>
    <?php
}


