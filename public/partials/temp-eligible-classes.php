<?php 
$public_class = new CFPA_Booking_System_Public('cfpa public class', 1);

$eligible_classes = $public_class->get_eligible_classes(get_current_user_id());
$args = array(
	'post_type' => 'class',
	'post_status' => 'publish',
	'post__in' => $eligible_classes,
	'posts_per_page' => -1,
);
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>

	<!-- pagination here -->

	<!-- the loop -->
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	
	
		<div id="id-<?php echo get_the_id(); ?>-cfpaid-<?php echo get_post_meta(get_the_ID(),'class-ref-no', true); ?>" class="section group <?php echo get_post_meta(get_the_ID(),'class-category', true); ?>">
			<div class="col span_1_of_12">
				<?php echo get_post_meta(get_the_ID(),'class-ref-no', true); ?>
			</div>
			<div class="col span_5_of_12">
				<?php the_title(); ?>
			</div>
			<div class="col span_3_of_12">
			
			</div>
			
<!--
			<div class="col span_1_of_12">
				
			</div>
			<div class="col span_1_of_12">
				
			</div>
-->
		</div>


	<?php endwhile; ?>
	<!-- end of the loop -->

	<!-- pagination here -->

	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
