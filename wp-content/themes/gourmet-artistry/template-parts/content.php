<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gourmet_Artistry
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

	<?php if ( is_single() ) { ?>
			<div class="large-12 columns">
					<?php the_post_thumbnail('single-image', array('class' => 'thumbnail')); ?>
			</div>
		<?php } else { ?>
			<div class="large-6 columns">
				<?php the_post_thumbnail('entry'); ?>
			</div>
	<?php } ?>

	<div class="<?php echo is_single() ? 'large-12' : 'large-6' ?> columns">

	<header class="entry-header">
		<?php
			if ( is_single() ) {
				the_title( '<h1 class="entry-title text-center separator">', '</h1>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php gourmet_artistry_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if('recipes' === get_post_type()): ?>
			<div class="taxonomies">
				<div class="price-range">
					<?php echo get_the_term_list($post->ID, 'price_range', 'Price Range: ', ', ', ''); ?>
				</div>
				<div class="meal-type">
					<?php echo get_the_term_list($post->ID, 'meal-type', 'Meal: ', ', ', ''); ?>
				</div>
				<div class="course">
					<?php echo get_the_term_list($post->ID, 'course', 'Course: ', ', ', ''); ?>
				</div>
				<div class="mood">
					<?php echo get_the_term_list($post->ID, 'mood', 'Mood: ', ', ', ''); ?>
				</div>
			</div>
			<?php if(is_single()): ?>
				<div class="extra-information">
					<?php $calories = get_post_meta(get_the_ID(), 'input-metabox', true); ?>
					<?php if($calories) : ?>
						<div class="calories">
							<p>Calories: <?php echo $calories; ?></p>
						</div>
					<?php endif; ?>
					<?php $rating = get_post_meta(get_the_ID(), 'dropdown-metabox', true); ?>
					<?php if($rating) : ?>
						<div class="rating">
							<p>Rating: <?php echo $rating; ?></p>
						</div>
					<?php endif; ?>
					<?php $description = get_post_meta(get_the_ID(), 'textarea-metabox', true); ?>
					<?php if($description) : ?>
						<div class="rating">
							<p>Recipe Description: <?php echo $description; ?></p>
						</div>
					<?php endif; ?>
				</div> <!-- .extra-information -->

			<?php endif; ?> <!-- Checking if is_single() -->
		<?php endif; ?> <!-- if('recipes' === get_post_type()): ?>
			<?php
				if(is_single()) {
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'gourmet-artistry' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
				} else {
					the_excerpt();
					echo '<a class="button" href='.get_the_permalink() . ">Read More</a>";
				}

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gourmet-artistry' ),
					'after'  => '</div>',
				) );
			?> -->
			<a class="previous_recipe_link" href="<?php echo get_permalink(get_previous_post()->ID); ?>" data-previous-recipe="<?php echo get_previous_post()->ID; ?>">Previous Recipe</a>
	</div> <!-- .entry-content -->

	</div>
</article><!-- #post-## -->
