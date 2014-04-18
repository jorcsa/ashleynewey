<?php

//delete post

function delete_data($post_id) {

    global $wpdb;

    $wpdb->query("DELETE FROM andev_reservations WHERE tour_id = '$post_id'");

}

add_action('delete_post', 'delete_data');



//remove tags

function remove_submenus() {

    global $submenu;

    unset($submenu['edit.php'][16]); // Removes 'Tags'.

}

add_action('admin_menu', 'remove_submenus');



//change labels

function change_post_menu_label() {

    global $menu;

    global $submenu;

    $menu[5][0] = 'Tours';

    $submenu['edit.php'][5][0] = 'Tours';

    $submenu['edit.php'][10][0] = 'Add Tours';

    $submenu['edit.php'][15][0] = 'Categories';

    echo '';

}

function change_post_object_label() {

    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;

    $labels->name = 'Tours';

    $labels->singular_name = 'Tour';

    $labels->add_new = 'Add Tours';

    $labels->add_new_item = 'Add Tour';

    $labels->edit_item = 'Edit Tour';

    $labels->new_item = 'Tour';

    $labels->view_item = 'View Tour';

    $labels->search_items = 'Search Tours';

    $labels->not_found = 'No Tours found';

    $labels->not_found_in_trash = 'No Tours found in Trash';

}

add_action( 'init', 'change_post_object_label' );

add_action( 'admin_menu', 'change_post_menu_label' );



//add reservations

function add_submenus() {

    global $pw_settings_page;

    $pw_settings_page = add_posts_page('Reservations', 'Reservations', 'read', 'reservations', 'reservations_function');

}

add_action('admin_menu', 'add_submenus');



//js and css

function pw_load_scripts($hook) {

    global $pw_settings_page;

    if( $hook != $pw_settings_page )

        return;



    wp_enqueue_script( 'jquery-js', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');

    wp_enqueue_script( 'dataTables-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.min.js');

    wp_enqueue_script( 'dataTables-ColVis-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.ColVis.min.js');

    wp_enqueue_script( 'ZeroClipboard-js', '/wp-content/themes/ashleyandnewey/assets/js/ZeroClipboard.js');

    wp_enqueue_script( 'dataTables-TableTools-js', '/wp-content/themes/ashleyandnewey/assets/js/jquery.dataTables.TableTools.min.js');

    wp_enqueue_script( 'main-admin-js', '/wp-content/themes/ashleyandnewey/assets/js/main-admin.js');



    wp_enqueue_style( 'dataTables-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.css' );

    wp_enqueue_style( 'dataTables-ColVis-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.ColVis.css' );

    wp_enqueue_style( 'dataTables-TableTools-css', '/wp-content/themes/ashleyandnewey/assets/css/jquery.dataTables.TableTools.css' );

    wp_enqueue_style( 'style-admin-css', '/wp-content/themes/ashleyandnewey/assets/css/style-admin.css' );

}

add_action('admin_enqueue_scripts', 'pw_load_scripts');



//reservations

function reservations_function(){

    global $wpdb;

    $reservations = $wpdb->get_results(

        "SELECT * FROM andev_reservations ORDER BY time"

    );

    ?>

    <div id="rTable" class="ad-table">

        <table cellpadding="0" cellspacing="0" border="0" class="display" id="reservation-table">

            <thead>

            <tr>

                <th>Tour</th>

                <th>Date</th>

                <th>Company</th>

                <th>Name</th>

                <th>Reserve date</th>

                <th>Confirmation</th>

                <th>Delete</th>

            </tr>

            </thead>

            <tbody>

            <?php

            foreach ($reservations as $reservation){

                $user_info = get_userdata($reservation->user_id);

                ?>

                <tr data-id="<?php echo $reservation->id; ?>">

                    <td class="center"><?php echo get_the_title($reservation->tour_id); ?> </td>

                    <td class="center"><?php echo str_replace("\\", "", $reservation->date); ?></td>

                    <td class="center"><?php echo $user_info->last_name; ?></td>

                    <td class="center"><?php echo $user_info->first_name; ?></td>

                    <td class="center"><?php echo $reservation->time; ?></td>

                    <td class="center">

                        <?php global $current_user; ?>
                        <?php if (isset($current_user->caps['administrator']) && $reservation->status == 1) : ?>
                            <button type="button" class="confirmation" data-id="<?php echo $reservation->id; ?>" onclick="alert('Are you sure?');">
                                Confirmation
                            </button>
                        <?php endif; ?>

                    </td>

                    <td class="center">

                        <button type="button" class="delete" data-id="<?php echo $reservation->id; ?>" onclick="return conf('Are you sure?');">Delete</button>

                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

            <tfoot>

            <tr>

                <th>Tour</th>

                <th>Date</th>

                <th>Company</th>

                <th>Name</th>

                <th>Reserve date</th>

                <th>Confirmation</th>

                <th>Delete</th>

            </tr>

            </tfoot>

        </table>

    </div>

<?php

}



?>