<?php get_header(); ?>

<div id="primary">
	<div id="content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<p><?php the_content(); ?></p>
			
			<!-- Adds in the contact form via its shortcode -->
			<div class='contact-form'><?php echo do_shortcode('[contact_form]'); ?></div>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer(); ?>

