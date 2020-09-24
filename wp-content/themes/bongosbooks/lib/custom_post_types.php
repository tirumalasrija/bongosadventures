<?php

/**
* Creates custom post type for lessons
*/

add_action( 'init', 'lessons_post_type', 0 );
function lessons_post_type() {
    $labels = array(
    'name'                  => _x( 'Lessons', 'Post Type General Name', 'text_domain' ),
    'singular_name'         => _x( 'Lesson', 'Post Type Singular Name', 'text_domain' ),
    'menu_name'             => __( 'Lessons', 'text_domain' ),
    'name_admin_bar'        => __( 'Lessons', 'text_domain' ),
    'archives'              => __( 'Lesson Archives', 'text_domain' ),
    'attributes'            => __( 'Lesson Attributes', 'text_domain' ),
    'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
    'all_items'             => __( 'All Lessons', 'text_domain' ),
    'add_new_item'          => __( 'Add New Lesson', 'text_domain' ),
    'add_new'               => __( 'Add New', 'text_domain' ),
    'new_item'              => __( 'New Lesson', 'text_domain' ),
    'edit_item'             => __( 'Edit Lesson', 'text_domain' ),
    'update_item'           => __( 'Update Lesson', 'text_domain' ),
    'view_item'             => __( 'View Lesson', 'text_domain' ),
    'view_items'            => __( 'View Lessons', 'text_domain' ),
    );
    $args = array(
    'label'                 => __( 'Lesson', 'text_domain' ),
    'description'           => __( 'Lessons', 'text_domain' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
    'taxonomies'            => array( 'category', 'post_tag' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-welcome-learn-more',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'page',
    );
    register_post_type( 'lessons', $args );
}


/**
* Creates custom post type for Events
*/
