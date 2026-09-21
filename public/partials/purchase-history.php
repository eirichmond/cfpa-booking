<?php
$public_class = new CFPA_Booking_System_Public('cfpa booking system', '1.0.2');
$purchases = $public_class->cfpa_user_purchase_histroy();


get_header(); ?>


<div class="cfparow">
	<div class="section group">

		<div class="col span_4_of_12">

			<?php if ( is_active_sidebar( 'account-booking' ) ) : ?>
				<?php dynamic_sidebar( 'account-booking' ); ?>
			<?php endif; ?>

		</div>

		<div class="col span_8_of_12">

			<?php while ( have_posts() ) : the_post(); ?>

				<div class="user-profile block">

					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-content">
						<?php the_content(); ?>
						All purchases below were completed with the email address listed in your account. If you have trouble locating purchases, please <a href="/contact-us/">contact us</a> for assistance.
					</div>

				</div>

			<?php endwhile; ?>

			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Date</th>
						<th style="text-align:right;">Cost</th>
						<th style="text-align:right;">Invoice</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach($purchases as $purchase) { $pounds = $purchase['cost'] / 100; ?>
						<tr>
							<td>#<?php echo esc_html($purchase['ID']); ?></td>
							<td><?php echo esc_html(date('jS M, Y', strtotime($purchase['date']))); ?></td>
							<td style="text-align:right;">&pound;<?php echo esc_html(number_format($pounds, 2, '.', ' ')); ?></td>
							<td style="text-align:right;"><a href="<?php echo get_the_permalink($purchase['ID']); ?>" target="_blank">View Invoice</a></td>
						</tr>
					<?php } ?>

				</tbody>
			</table>


		</div>
	</div>
</div>

<?php get_footer(); ?>