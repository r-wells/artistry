<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gourmet_Artistry
 */
get_header(); ?>

<?php get_template_part('template-parts/slider', 'entries'); ?>

<div class="meal-recipes row">
	<h2 id="time" class="text-center">Make This For: </h2>
	<ul id="meal-per-hour" class="no-bullet">
		
	</ul>
</div>

<div id="filter">
	<h2 class="text-center">Filter By Course: </h2>
	<!-- <button onClick="myFunction()" class="clickme">Click Me</button> -->
	<div class="menu-centered">
		<ul class="menu">
			<?php $terms = get_terms(array(
				'taxonomy' => 'course',
			));
			foreach($terms as $term){
				echo "<li><a href='#{$term->slug}'>{$term->name}</a></li>";
			}
			?>
		</ul>
	</div> <!-- .menu-center -->
	<div id="recipes">
		<?php foreach($terms as $term){ 
				filter_course_terms($term->slug); 	 
		}?>

	</div> <!--#recipes -->
</div>	<!-- #filter -->

<div id="search-form" class="row">
	<h2 class="text-center">Advanced Search</h2>
	<div class="search">
		<input type="text" name="recipe_name" id="recipe_name" placeholder="Search By Recipe Name...">
		<select name="calories" id="calories">
			<option selected="true" disabled="disabled">Calories</option>
			<option value="0-200">200 or less</option>
			<option value="201-400">201 to 400</option>
			<option value="401-600">401 to 600</option>
			<option value="601-10000">600 to 10000</option>
		</select>
		<select name="price_range" id="price_range">
			<?php
				$terms = get_terms('price_range', array(
					'hide-empty' => false
				));
				foreach($terms as $term) {
					echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
				}
			?>
		</select>

		<select name="course" id="course">
			<?php
				$terms = get_terms('course', array(
					'hide-empty' => false
				));
				foreach($terms as $term) {
					echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
				}
			?>
		</select>
		<button id="search-btn" type="button" class="button">Search</button>
	</div>

	<div id="result" class="row">

	</div>
	<div id="results_found" class="row">

	</div>
</div>

<div class="row">
	<div id="primary" class="content-area medium-8 columns">
		<main id="main" class="site-main" role="main">
			<h2 class="latest-entries text-center separator">Latest Entries</h2>
		<?php
		if ( have_posts() ) :
			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>

				</header>

			<?php
			endif;
			/* Start the Loop */
			while ( have_posts() ) : the_post();
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );
			endwhile;
			the_posts_navigation();
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
echo "</div>";
get_footer();
