<?php

//creating the custom post type - testimonials

function jakes_register_cpt_testimonials () {
    
    $singular = 'Testimonial';
    $plural = 'Testimonials';
    $plural_slug = str_replace( ' ', '_', $plural );
    
    $labels = array(
        'name'               => $plural,
        'singular_name'      => $singular,
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New ' . $singular,
        'edit_item'          => 'Edit ' . $singular,
        'new_item'           => 'New ' . $singular,
        'view_item'          => 'View ' . $singular,
        'view_items'         => 'View ' . $plural,
        'search_items'       => 'Search ' . $plural,
        'not_found'          => 'No ' . $plural . ' found',
        'not_found_in_trash' => 'No ' . $plural . ' found in trash, sorry!',
        'all_items'          => 'All ' . $plural,
    );
        
    $args = array(
        'labels'                 => $labels,
        'public'                 => true,
        'exclude_from_search'    => false,
        'publicly_queryable'     => true,
        'show_ui'                => true,
        'show_in_nav_menus'      => true,
        'show_in_menu'           => true,
        'show_in_admin_bar'      => true,
        'menu_position'          => 10,
        'menu_icon'              => 'dashicons-format-quote',
        'capability_type'        => 'post',
        'map_meta_cap'           => true,
        'hierarchical'           => false,
        'has_achive'             => true,
        'rewrite'                => array ( 'slug' => strtolower($plural_slug), 'with_front' => true, 'pages' => true, 'feeds' => true, ),
        'query_var'              => true,
        'can_export'             => true,
        'delete_with_user'       => false,
        'supports'               => array ( 'title', 'editor' ),
    );
    
    register_post_type ( 'testimonial', $args );
}

add_action ( 'init', 'jakes_register_cpt_testimonials' );

//creating the custom post type - casestudies

function jakes_register_cpt_casestudies () {
    
    $singular = 'Case Study';
    $plural = 'Case Studies';
    $plural_slug = str_replace( ' ', '_', $plural );
    
    $labels = array(
        'name'               => $plural,
        'singular_name'      => $singular,
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New ' . $singular,
        'edit_item'          => 'Edit ' . $singular,
        'new_item'           => 'New ' . $singular,
        'view_item'          => 'View ' . $singular,
        'view_items'         => 'View ' . $plural,
        'search_items'       => 'Search ' . $plural,
        'not_found'          => 'No ' . $plural . ' found',
        'not_found_in_trash' => 'No ' . $plural . ' found in trash, sorry!',
        'all_items'          => 'All ' . $plural,
    );
        
    $args = array(
        'labels'                 => $labels,
        'public'                 => true,
        'exclude_from_search'    => false,
        'publicly_queryable'     => true,
        'show_ui'                => true,
        'show_in_nav_menus'      => true,
        'show_in_menu'           => true,
        'show_in_admin_bar'      => true,
        'menu_position'          => 10,
        'menu_icon'              => 'dashicons-search',
        'capability_type'        => 'post',
        'map_meta_cap'           => true,
        'hierarchical'           => false,
        'has_achive'             => true,
        'rewrite'                => array ( 'slug' => strtolower($plural_slug), 'with_front' => true, 'pages' => true, 'feeds' => true, ),
        'query_var'              => true,
        'can_export'             => true,
        'delete_with_user'       => false,
        'supports'               => array ( 'title', 'editor' ),
    );
    
    register_post_type ( 'casestudy', $args );
}

add_action ( 'init', 'jakes_register_cpt_casestudies' );





/* 

======================
  messages system
======================

*/





//creating the custom post type - messages

function jakes_register_cpt_messages () {

    $singular = 'Message';
    $plural = 'Messages';

    $labels = array(
        'name'           => $plural,
        'singular_name'  => $singular,
        'menu_name'      => $plural,
        'name_admin_bar' => $singular,
        'edit_item'      => $singular
    );

    $supports = array (
        'title',
        'editor',
    );
    
    $capabilities = array(
        'create_posts' => 'do_not_allow'
    );

    $args = array(
        'labels'          => $labels,
        'menu_icon'       => 'dashicons-email-alt',
        'show_ui'         => true,
        'show_in_menu'    => true,
        'capability_type' => 'post',
        'capabilities'    => $capabilities,
        'map_meta_cap'    => true,
        'hierarchical'    => false,
        'menu_position'   => 26,
        'supports'        => $supports
    );

    register_post_type ( 'message', $args);
}

add_action ( 'init', 'jakes_register_cpt_messages' );


//this function goes into 'manage_message_posts_columns, gets the $columns variable and replaces it with $newColumns'
function jakes_edit_message_columns( $columns ) {
    $newColumns = array();
    //this used to exist in $columns, so we're adding it back in again so we don't lose it when we replace with $newColumns
    $newColumns['cb'] = '<input type="checkbox" />';
    $newColumns['title'] = 'Full Name';
    $newColumns['message'] = 'Message';
    $newColumns['email'] = 'Email';
    $newColumns['date'] = 'Date';
    return $newColumns;
}

add_filter ( 'manage_message_posts_columns', 'jakes_edit_message_columns');



//goes through the columns specify what 'message' and 'email' should display. title and date already have values in $columns - check codex 'manage_${post_type}_posts_column'
function jakes_message_custom_column ( $column, $post_id) {
    switch( $column ) {
        
        case 'message':
            echo get_the_excerpt();
            break;
       
        case 'email' : 
            $email = get_post_meta( $post_id, '_message_email_value_key', true );
            echo '<a href="mailto:'.$email.'">'.$email.'</a>';
            break;
    }
}
add_action ( 'manage_message_posts_custom_column', 'jakes_message_custom_column', 10, 2 );

//Adding a metabox to Messages

function jakes_message_add_metabox() {
    add_meta_box(
     'message_email', 
     'User Email', 
     'jakes_message_email_callback', 
     'message'
    );
}

//creating the label and input field inside the metabox usimg a callback functiom
function jakes_message_email_callback( $post ) {

    //creating the nonce field
    wp_nonce_field( 'jakes_save_email_data', 'jakes_message_email_metabox_nonce');
    //this variable collects the email value from the database,
    $value = get_post_meta( $post->ID, '_message_email_value_key', true); 
    //in value we enter the $value variable we just made so that it displays the data in the database (if there is any)
    echo '<label for="jakes_message_email_field">User Email Address</label>';
    echo '<input type="email" id="jakes_message_email_field" name="jakes_message_email_field" value="' . esc_attr($value) . '" size="25"/>';
}

add_action( 'add_meta_boxes' ,'jakes_message_add_metabox');


//making it possible to save the data into our database
function jakes_save_email_data ( $post_id ) {

    //in order to save we have to check a few things for safety
    //check if nonce exists
    if ( ! isset( $_POST['jakes_message_email_metabox_nonce'])) {
        return;
    }

    //verify the nonce
    if ( ! wp_verify_nonce( $_POST['jakes_message_email_metabox_nonce'], 'jakes_save_email_data') ){
        return;
    }

    //check it is not an autosave
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    //check if the user has permission to save
    if ( ! current_user_can( 'edit_post', $post_id) ) {
        return;
    }

    //check if there is even a value in the field to save
    if ( ! isset( $_POST['jakes_message_email_field'])) {
        return;
    }

    //now we have to specify the data we want to save, in this case, this is the id of the input html element
    $save_data = sanitize_text_field($_POST['jakes_message_email_field']);

    //this is the actual saving of the data to the database
    update_post_meta( $post_id, '_message_email_value_key', $save_data);
}

add_action ('save_post', 'jakes_save_email_data');

//prevent user from ever being able to edit the messages by removing publish box


function jakes_remove_publish_mbox()
{
    remove_meta_box( 'submitdiv', 'message', 'side' );
}

add_action( 'do_meta_boxes', 'jakes_remove_publish_mbox', 10, 3 );




