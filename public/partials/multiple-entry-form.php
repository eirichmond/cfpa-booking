<?php

$user_id = get_current_user_id();

if (user_can($user_id, 'multiple')) {
	$is_school = true;
}

get_header();
?>


<div class="cfparow">
	<div class="section group">
		<div class="col span_3_of_12">

			<?php if ( is_active_sidebar( 'account-booking' ) ) : ?>
				<?php dynamic_sidebar( 'account-booking' ); ?>
			<?php endif; ?>

		</div>
		<div class="col span_9_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="user-profile block">

					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

                    <?php do_csv_instructions(); ?>



				</div>


			<?php endwhile; ?>


		</div>
	</div>
</div>



<?php get_footer(); ?>
