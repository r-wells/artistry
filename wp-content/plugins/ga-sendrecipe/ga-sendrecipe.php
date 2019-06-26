<?php
/*
Plugin Name: Gourmet Artistry Send Recipe
Plugin URI:
Description: Allows users to submit recipes from the front end.
Version: 1.0
Author: Juan De la torre Valdez
License: GPL2
License: URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

//Holds all the firls for the front end form


function ga_form_fields() {
    $cmb = new_cmb2_box(
        array(
            'id' => 'ga_send_recipe_frontend',
            'object_type' => array('page'),
            'hookup' => false, //Hookup checks if current page should save the form
            'save_firls' => false
    ) );

    $cmb->add_field(array(
        'name' => 'General Information of the Recipe',
        'type' => 'title',
        'id' => 'recipe_heading'
    ));

    $cmb->add_field(array(
        'name' => 'Recipe Title',
        'id' => 'recipe_title',
        'type' => 'text'
    ));

    $cmb->add_field(array(
        'name' => 'Recipe Subtitle',
        'id' => 'recipe_subtitle',
        'type' => 'text'
    ));

    $cmb->add_field(array(
        'name' => 'Recipe',
        'id' => 'recipe_content',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 12,
            'media_buttons' => false
        )
    ));

    $cmb->add_field(array(
        'name' => 'Calories',
        'id' => 'recipe_calories',
        'type' => 'text'
    ));

    $cmb->add_field(array(
        'name' => 'Recipe Image',
        'id' => 'feature_image',
        'type' => 'text',
        'attributes' => array(
            'type' => 'file'
        )
    ));

    $cmb->add_field(array(
        'name' => 'Additional Information',
        'id' => 'additional_information',
        'type' => 'text'
    ));

    $cmb->add_field(array(
        'name' => 'Price',
        'id' => 'price_range',
        'type' => 'taxonomy_select',
        'taxonomy' => 'price_range'
    ));

    $cmb->add_field(array(
        'name' => 'Meal',
        'id' => 'meal_type',
        'type' => 'taxonomy_select',
        'taxonomy' => 'meal-type'
    ));

    $cmb->add_field(array(
        'name' => 'Course',
        'id' => 'course',
        'type' => 'taxonomy_select',
        'taxonomy' => 'course'
    ));

    $cmb->add_field(array(
        'name' => 'Mood',
        'id' => 'mood',
        'type' => 'text',
        'description' => 'Add Mood Seperated By Comma'
    ));

    $cmb->add_field(array(
        'name' => 'Author Information',
        'id' => 'author_information',
        'type' => 'title'
    ));

    $cmb->add_field(array(
        'name' => 'Your Name',
        'desc' => 'Add your name for the recipe',
        'id' => 'author_recipe',
        'type' => 'text'
    ));

    $cmb->add_field(array(
        'name' => 'Author Email',
        'id' => 'author_email',
        'type' => 'text_email',
        'desc' => 'Please add your email for follow ups'
    ));
}
add_action( 'cmb2_init', 'ga_form_fields' );

//Gets an instance of the form
function ga_form_values() {
    //Id of the metabox
    $metabox_id = 'ga_send_recipe_frontend';

    //Pass an object ID, post type is going to be added later
    $object_id = 'fake-object-id';

    //Returns an instance of the form
    return cmb2_get_metabox($metabox_id, $object_id);
}

function ga_display_form_shortcode() {  
    //Gets an instance of the form
    $cmb = ga_form_values();

    //Prints the page or shortcode content
    $output = '';

    //Error printing
    if(($error = $cmb->prop('submission_error')) && is_wp_error( $error )) {
        $output .= '<h3>' . sprintf('There was an error <strong>%s</strong>', $error->get_error_message() ) . '</h3>';
    }

    //If the post was submitted successfully
    if(isset($_GET['post_submitted']) && ( $post = get_post(absint($_GET['post_submitted'] ) ) ) ) {
        //Get submitter name
        $name = get_post_meta($post->ID, 'author_recipe', 1);
        $name = $name ? ' ' . $name : '';

        //Print the message
        $output .= '<h3>' . sprintf('Thank you %s for your submission. Once it\'s approved, we will publish it!', esc_html($name)) . '</h3>';
    }

    //Print the form
    $output .= cmb2_get_metabox_form($cmb, 'fake-object-id', array('save_button' => 'Send Recipe') );

    return $output;
}
add_shortcode( 'ga_send_recipe', 'ga_display_form_shortcode');

//Handles form submission on save, save to the databae and redirect or sets the submissionb_error
function ga_insert_recipe() {
    //Return false if the user doesn't submit anything
    if(empty($_POST) || !isset($_POST['submit-cmb'], $_POST['object_id'])) {
        return false;
    }

    //Get an instance of the form
    $cmb = ga_form_values();

    //$post_data is the content of the post that will be submitted
    $post_data = array();

    //Check security
    if(!isset($_POST[$cmb->nonce()]) || ! wp_verify_nonce( $_POST[$cmb->nonce()], $cmb->nonce() )) {
        return $cmb->prop('submission_error', new WP_Error('security_fail', 'Security check failed') );
    }

    //Check that the post title is not empty
    if(empty($_POST['recipe_title'])) {
        return $cmb->prop('submission_error', new WP_Error('post_data_missing', 'A title is required'));
    }

    //Sanitize data
    $sanitize_values = $cmb->get_sanitized_values($_POST);

    //Add info to the post_data
    $post_data['post_title'] = $sanitize_values['recipe_title'];
    unset($sanitize_values['recipe_title']);

    //Add the content into post_data
    $post_data['post_content'] = $sanitize_values['recipe_content'];
    unset($sanitize_values['recipe_contnet']);

    $mood = explode(',', $sanitize_values['mood']);

    //Add taxonomies into post_data
    $post_data['tax_input'] = array(
        'price_range' => $sanitize_values['price_range'],
        'meal-type' => $sanitize_values['meal_type'],
        'course' => $sanitize_values['course'],
        'mood' => $mood
    );

    //Fill the metaboxes
    $post_data['meta_input'] = array(
        //calories
        'input-metabox' => $sanitize_values['recipe_calories'],
        //subtitle
        'textarea-metabox' => $sanitize_values['recipe_subtitle']
    );

    //Set the post type
    $post_data['post_type'] = 'recipes';

    //insert the post
    $new_id = wp_insert_post($post_data, true);

    //If there is an error print it
    if(is_wp_error($new_id)) {
        return $cmb->prop('submission_error', $new_id);
    }

    //Save all data into post
    $cmb->save_fields($new_id, 'post', $sanitize_values);

    //Add the featured image
    $img_id = ga_send_featured_image($new_id, $post_data);

    //If there are no errrs, uplod the image
    if($img_id && !is_wp_error($img_id)) {
        set_post_thumbnail($new_id, $img_id);
    }

    //redirect if the post is submitted already to prevent duplicate posts
    wp_redirect(esc_url_raw(add_query_arg('post_submitted', $new_id) ) );
    exit;

    // echo "<pre>";
    // var_dump($post_data);
    // echo "</pre>";
}
add_action('cmb2_after_init', 'ga_insert_recipe');

//Send featured image with the data
function ga_send_featured_image($post_data, $attachment_post_data = array()) {
    //Make sure a file was submitted
    if( empty($_FILES) || !isset($_FILES['featured_image']) && 0 != $_FILES['featured_image']['error'])  {
        return;
    }

    //Filter the empty array values
    $file = array_filter($_FILES['featured_image']);

    //Check that a file was submitted
    if(empty($file)) {
        return;
    }

    //Use the media uploader in the frontend
    if(!function_exists('media_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
    }

    //Upload the file and set return back the attachment id
    return media_handle_upload('featured_image', $post_id, $attachment_post_data);
}