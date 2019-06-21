<?php
/*
Plugin Name: CMB2 Plugin For Gourmet Artistry
Plugin URI:
Description: Adds CMB2 Features to site.
Version: 1.0
*/

//Adding the CMB2 Files
if( file_exists( dirname(__FILE__) . '/CMB2/init.php' ) ) {
    require_once dirname(__FILE__) . '/CMB2/init.php';
}

//Load custom css for cmb2
add_action( 'wp_enqueue_scripts', 'gourmet_artistry_metaboxes_css' );

function gourmet_artistry_metaboxes_css() {
	wp_register_style( 'metaboxes-css', plugins_url( 'ga-cmb2/css/ga-cmb2-styles.css' ) );
	wp_enqueue_style( 'metaboxes-css' );
}

//Function Printing Upcoming Events With Shortcode API
add_shortcode( 'upcoming-events', 'upcoming_events');
function upcoming_events($text) {
    $args = array(
        'post_type' => 'events',
        'orderby' => 'meta_value',
        'meta_key' => 'ga_fields_events_date',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'ga_fields_events_date',
                'value' => time(),
                'compare' => '>=',
                'type' => 'NUMERIC'
            )
        ),
    );

    echo "<h2 class='text-center'>" . $text['text'] . "</h2>";
    echo "<ul class='list-events no-bullet'>";
    $events = new WP_Query($args); 
    
    while($events->have_posts()): $events->the_post();
    echo "<li>";
    echo the_title('<h3 class="text-center">', '</h3>');
    echo "<div class='row '>";
    echo "<div class='medium-6 columns '>";
    echo "<div class='event-info'>";
    echo get_the_term_list($post->ID, 'type_event','<p><b>Type:</b> ', ', ', '');
    echo "<p><b>Seats Available: </b>" . get_post_meta(get_the_ID(), 'ga_fields_events_seats', true);
    echo "<p><b>City: </b>" . get_post_meta(get_the_ID(), 'ga_fields_events_city', true);
  
    $dateEvent = get_post_meta(get_the_ID(), 'ga_fields_events_date', true);
    echo "<p class='date-event'><b>Date: </b>" . gmdate('d-m-Y', $dateEvent) . " <b> Time: </b>" . gmdate('H:i', $dateEvent) . " </p>";
    echo "</div>";
    echo "</div>";
    echo "<div class='medium-6 columns agenda'>";
    echo "<h4 class='text-center'>Agenda of the Event</h4>";
  
    $agenda = get_post_meta(get_the_ID(), 'ga_fields_events_program', true);
    foreach ($agenda as $a) {
      echo "<p>{$a}</p>";
    }
    echo "</div>";
    echo "</div>";
    echo "</li>";
    endwhile;
    wp_reset_postdata();
    echo "</ul>";
}

//Function printing past events With Shortcode API
add_shortcode( 'past-events', 'past_events');
function past_events($text) {
    $args = array(
        'post_type' => 'events',
        'orderby' => 'meta_value',
        'meta_key' => 'ga_fields_events_date',
        'order' => 'ASC',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'ga_fields_events_date',
                'value' => time(),
                'compare' => '<=',
                'type' => 'NUMERIC'
            )
        ),
    );

    echo "<h2 class='text-center'>" . $text['text'] . "</h2>";
    echo "<ul class='list-events no-bullet'>";
    $events = new WP_Query($args); 
    
    while($events->have_posts()): $events->the_post();
    echo "<li>";
    echo the_title('<h3 class="text-center">', '</h3>');
    echo "<div class='row '>";
    echo "<div class='medium-6 columns '>";
    echo "<div class='event-info'>";
    echo get_the_term_list($post->ID, 'type_event','<p><b>Type:</b> ', ', ', '');
    echo "<p><b>Seats Available: </b>" . get_post_meta(get_the_ID(), 'ga_fields_events_seats', true);
    echo "<p><b>City: </b>" . get_post_meta(get_the_ID(), 'ga_fields_events_city', true);
  
    $dateEvent = get_post_meta(get_the_ID(), 'ga_fields_events_date', true);
    echo "<p class='date-event'><b>Date: </b>" . gmdate('d-m-Y', $dateEvent) . " <b> Time: </b>" . gmdate('H:i', $dateEvent) . " </p>";
    echo "</div>";
    echo "</div>";
    echo "<div class='medium-6 columns agenda'>";
    echo "<h4 class='text-center'>Agenda of the Event</h4>";
  
    $agenda = get_post_meta(get_the_ID(), 'ga_fields_events_program', true);
    foreach ($agenda as $a) {
      echo "<p>{$a}</p>";
    }
    echo "</div>";
    echo "</div>";
    echo "</li>";
    endwhile;
    wp_reset_postdata();
    echo "</ul>";
}

//Adding the fields to the events
add_action('cmb2_admin_init', 'metaboxes_events_cmb2');
function metaboxes_events_cmb2() {
    $prefix = 'ga_fields_events_';

    $metabox_events = new_cmb2_box( array(
        'id' => $prefix . 'metabox',
        'title' => __('Events Metaboxes', 'cmb2'),
        'object_types' => array('events')
    ));

    $metabox_events->add_field(array(
        'name' => __('City', 'cmb2'),
        'desc' => __('City where the event takes place', 'cmb2'),
        'id' => $prefix . 'city',
        'type' => 'text'
    ));

    $metabox_events->add_field(array(
        'name' => __('Event Date', 'cmb2'),
        'desc' => __('Event Date (pick from calendar)', 'cmb2'),
        'id' => $prefix . 'date',
        'type' => 'text_datetime_timestamp'
    ));

    $metabox_events->add_field(array(
        'name' => __('Seats Available', 'cmb2'),
        'desc' => __('Enter number of seats available', 'cmb2'),
        'id' => $prefix . 'seats',
        'type' => 'text'
    ));

    $metabox_events->add_field(array(
        'name' => __('Program', 'cmb2'),
        'desc' => __('Add the Program for this event', 'cmb2'),
        'id' => $prefix . 'program',
        'type' => 'text',
        'repeatable' => true
    ));
}