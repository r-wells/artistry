<?php
/*
Plugin Name: Gourmet Artistry Post Types & Taxonomies
Plugin URI:
Description: Adds Custom Post Types to site.
Version: 1.0
Author: Juan De la torre Valdez
License: GPL2
License: URI: https://www.gnu.org/licenses/gpl-2.0.html
*/



add_action('init', 'ga_recipe_post_type', 0 );
add_action('init', 'ga_events_post_type', 0 );
add_action('init', 'meal_type_taxonomy');
add_action('init', 'course_taxonomy');
add_action('init', 'mood_taxonomy');
add_action( 'init', 'type_event', 0 );

function type_event() {

	$labels = array(
		'name'                       => _x( 'Types of Event', 'Taxonomy General Name', 'gourmet-artistry' ),
		'singular_name'              => _x( 'Type of Event', 'Taxonomy Singular Name', 'gourmet-artistry' ),
		'menu_name'                  => __( 'Type of Event', 'gourmet-artistry' ),
		'all_items'                  => __( 'All Types of Event', 'gourmet-artistry' ),
		'parent_item'                => __( 'Parent Type of Event', 'gourmet-artistry' ),
		'parent_item_colon'          => __( 'Parent Type of Event:', 'gourmet-artistry' ),
		'new_item_name'              => __( 'New Type of Event', 'gourmet-artistry' ),
		'add_new_item'               => __( 'Add Type of Event', 'gourmet-artistry' ),
		'edit_item'                  => __( 'Edit Type of Event', 'gourmet-artistry' ),
		'update_item'                => __( 'Update Type of Event', 'gourmet-artistry' ),
		'view_item'                  => __( 'View Type of Event', 'gourmet-artistry' ),
		'separate_items_with_commas' => __( 'Separate Type of Event with commas', 'gourmet-artistry' ),
		'add_or_remove_items'        => __( 'Add or remove Type of Event', 'gourmet-artistry' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'gourmet-artistry' ),
		'popular_items'              => __( 'Popular Types of Event', 'gourmet-artistry' ),
		'search_items'               => __( 'Search Types of Event', 'gourmet-artistry' ),
		'not_found'                  => __( 'Not Found', 'gourmet-artistry' ),
		'no_terms'                   => __( 'No Types of Event', 'gourmet-artistry' ),
		'items_list'                 => __( 'Type of Event list', 'gourmet-artistry' ),
		'items_list_navigation'      => __( 'Type of Event list navigation', 'gourmet-artistry' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'type_event', array( 'events' ), $args );

}


function meal_type_taxonomy() {
  $labels = array(
  	'name'              => _x( 'Meal Type', 'taxonomy general name' ),
  	'singular_name'     => _x( 'Meal Type', 'taxonomy singular name' ),
  	'search_items'      => __( 'Search Meal Type' ),
  	'all_items'         => __( 'All Meal Types' ),
  	'parent_item'       => __( 'Parent Meal Type' ),
  	'parent_item_colon' => __( 'Parent Meal Type:' ),
  	'edit_item'         => __( 'Edit Meal Type' ),
  	'update_item'       => __( 'Update Meal Type' ),
  	'add_new_item'      => __( 'Add Meal Type' ),
  	'new_item_name'     => __( 'New Meal Type' ),
  	'menu_name'         => __( 'Meal Type' ),
  );

  $args = array(
    'hierarchical'  => true, //like categories or tags
    'labels'        => $labels,
    'show_ui'       => true, //add the default UI to this taxonomy
    'show_admin_column' => true, //add the taxonomies to the wordpress admin
    'query_var'         => true,
    'rewrite'       => array('slug' =>'meal'),
  );

  register_taxonomy( 'meal-type', 'recipes', $args );
}

function course_taxonomy() {
  $labels = array(
  	'name'              => _x( 'Course', 'taxonomy general name' ),
  	'singular_name'     => _x( 'Course', 'taxonomy singular name' ),
  	'search_items'      => __( 'Search Course' ),
  	'all_items'         => __( 'All Courses' ),
  	'parent_item'       => __( 'Parent Course' ),
  	'parent_item_colon' => __( 'Parent Course:' ),
  	'edit_item'         => __( 'Edit Course' ),
  	'update_item'       => __( 'Update Course' ),
  	'add_new_item'      => __( 'Add Course' ),
  	'new_item_name'     => __( 'New Course' ),
  	'menu_name'         => __( 'Course' ),
  );

  $args = array(
    'hierarchical'  => true, //like categories or tags
    'labels'        => $labels,
    'show_ui'       => true, //add the default UI to this taxonomy
    'show_admin_column' => true, //add the taxonomies to the wordpress admin
    'query_var'         => true,
    'rewrite'       => array('slug' =>'course'),
  );

  register_taxonomy( 'course', 'recipes', $args );
}


function mood_taxonomy() {
  $labels = array(
  	'name'              => _x( 'Mood', 'taxonomy general name' ),
  	'singular_name'     => _x( 'Mood', 'taxonomy singular name' ),
  	'search_items'      => __( 'Search Mood' ),
  	'all_items'         => __( 'All Moods' ),
  	'parent_item'       => __( 'Parent Mood' ),
  	'parent_item_colon' => __( 'Parent Mood:' ),
  	'edit_item'         => __( 'Edit Mood' ),
  	'update_item'       => __( 'Update Mood' ),
  	'add_new_item'      => __( 'Add Mood' ),
  	'new_item_name'     => __( 'New Mood' ),
  	'menu_name'         => __( 'Mood' ),
  );

  $args = array(
    'hierarchical'  => false, //like categories or tags
    'labels'        => $labels,
    'show_ui'       => true, //add the default UI to this taxonomy
    'show_admin_column' => true, //add the taxonomies to the wordpress admin
    'query_var'         => true,
    'rewrite'       => array('slug' =>'mood'),
  );

  register_taxonomy( 'mood', 'recipes', $args );
}

function ga_recipe_post_type() {

      // Labels for the Post Type
    $labels = array(
      'name'                => _x( 'Recipes', 'Post Type General Name', 'gourmet-artistry' ),
      'singular_name'       => _x( 'Recipe', 'Post Type Singular Name', 'gourmet-artistry' ),
      'menu_name'           => __( 'Recipes', 'gourmet-artistry' ),
      'parent_item_colon'   => __( 'Parent Recipe', 'gourmet-artistry' ),
      'all_items'           => __( 'All Recipes', 'gourmet-artistry' ),
      'view_item'           => __( 'View Recipe', 'gourmet-artistry' ),
      'add_new_item'        => __( 'Add New Recipe', 'gourmet-artistry' ),
      'add_new'             => __( 'Add New Recipe', 'gourmet-artistry' ),
      'edit_item'           => __( 'Edit Recipe', 'gourmet-artistry' ),
      'update_item'         => __( 'Update Recipe', 'gourmet-artistry' ),
      'search_items'        => __( 'Search Recipe', 'gourmet-artistry' ),
      'not_found'           => __( 'No recipes found', 'gourmet-artistry' ),
      'not_found_in_trash'  => __( 'Not found in trash', 'gourmet-artistry' ),
    );

    // Another Customizations
    $args = array(
        'label'   => __('Recipes','gourmet-artistry' ),
        'description' => __('Recipes for Gourmet Artistry', 'gourmet-artistry'),
        'labels'  => $labels,
        'supports' => array('title', 'editor', 'thumbnail','revisions'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menus' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-page',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'capability_type' => 'page',
    );

    // register the post Type
    register_post_type( 'recipes', $args);
}


function ga_events_post_type() {

      // Labels for the Post Type
    $labels = array(
      'name'                => _x( 'Events', 'Post Type General Name', 'gourmet-artistry' ),
      'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'gourmet-artistry' ),
      'menu_name'           => __( 'Events', 'gourmet-artistry' ),
      'parent_item_colon'   => __( 'Parent Event', 'gourmet-artistry' ),
      'all_items'           => __( 'All Events', 'gourmet-artistry' ),
      'view_item'           => __( 'View Event', 'gourmet-artistry' ),
      'add_new_item'        => __( 'Add New Event', 'gourmet-artistry' ),
      'add_new'             => __( 'Add New Event', 'gourmet-artistry' ),
      'edit_item'           => __( 'Edit Event', 'gourmet-artistry' ),
      'update_item'         => __( 'Update Event', 'gourmet-artistry' ),
      'search_items'        => __( 'Search Event', 'gourmet-artistry' ),
      'not_found'           => __( 'No events found', 'gourmet-artistry' ),
      'not_found_in_trash'  => __( 'Not found in trash', 'gourmet-artistry' ),
    );

    // Another Customizations
    $args = array(
        'label'   => __('Events','gourmet-artistry' ),
        'description' => __('Events for Gourmet Artistry', 'gourmet-artistry'),
        'labels'  => $labels,
        'supports' => array('title', 'editor',),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menus' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-calendar-alt',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'capability_type' => 'page',
    );

    // register the post Type
    register_post_type( 'events', $args);
}
