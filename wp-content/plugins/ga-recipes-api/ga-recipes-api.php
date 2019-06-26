<?php
/*
Plugin Name: Gourmet Artistry Recipes API
Plugin URI:
Description: Adds REST API to the website.
Version: 1.0
Author: Juan De la torre Valdez
License: GPL2
License: URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

ini_set('memory_limit', '256M');

add_action('wp_enqueue_scripts', 'ga_rest_api_scripts');

function ga_rest_api_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'ga-recipes-api-js', plugin_dir_url(__FILE__) . 'ga-recipes-api.js' );

    wp_localize_script( 
        'ga-recipes-api-js',
        'recipes_api',
        array(
            'rest_url' => rest_url('wp/v2/recipes-api/')
        )
    );
}

//Add custom values to the response
add_action('rest_api_init', 'ga_rest_api_custom_values');
function ga_rest_api_custom_values() {
    register_rest_field(
        'recipes',
        'ga_previous_recipe',
        array(
            'get_callback' => 'ga_previous_recipe_ID',
            'schema' => null,
            'update_callback' => null
        )
    );

    //Adds custom meta values
    register_rest_field(
        'recipes',
        'ga_recipes_meta',
        array(
            'get_callback' => 'ga_recipe_meta_information',
            'schema' => null,
            'update_callback' => null
        )
    );

    //Returns the taxonomies
    register_rest_field(
        'recipes',
        'ga_recipes_taxonomies',
        array(
            'get_callback' => 'ga_recipe_taxonomies_list',
            'schema' => null,
            'update_callback' => null
        )
    );

    //Return the terms associated to the recipe
    register_rest_field(
        'recipes',
        'ga_recipes_term_price_range',
        array(
            'get_callback' => 'ga_recipe_term_price_range',
            'schema' => null,
            'update_callback' => null
        )
    );

    //Return the terms associated to the recipe
    register_rest_field(
        'recipes',
        'ga_recipes_term_meal_type',
        array(
            'get_callback' => 'ga_recipe_term_meal_type',
            'schema' => null,
            'update_callback' => null
        )
    );

    //Return the terms associated to the recipe
    register_rest_field(
        'recipes',
        'ga_recipes_term_course',
        array(
            'get_callback' => 'ga_recipe_term_course',
            'schema' => null,
            'update_callback' => null
        )
    );

    //Return the terms associated to the recipe
    register_rest_field(
        'recipes',
        'ga_recipes_term_mood',
        array(
            'get_callback' => 'ga_recipe_term_mood',
            'schema' => null,
            'update_callback' => null
        )
    );
}

function ga_previous_recipe_ID() {
    return get_previous_post()->ID;
}

function ga_recipe_meta_information() {
    global $post;
    $post_id = $post->ID;
    return get_post_meta($post_id);
}

function ga_recipe_taxonomies_list(){
    global $post;
    return get_object_taxonomies( $post );
}

function ga_recipe_term_price_range(){
    global $post;
    $post_id = $post->ID;

    return get_the_term_list($post_id, 'price_range');
}

function ga_recipe_term_meal_type(){
    global $post;
    $post_id = $post->ID;

    return get_the_term_list($post_id, 'meal-type');
}

function ga_recipe_term_course(){
    global $post;
    $post_id = $post->ID;

    return get_the_term_list($post_id, 'course');
}

function ga_recipe_term_mood(){
    global $post;
    $post_id = $post->ID;

    return get_the_term_list($post_id, 'mood');
}