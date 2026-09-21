<?php get_header(); ?>

<div class="cfparow">
	<div class="section group">
		<div class="col span_8_of_12">
	
			<h1>Sorry you're not logged in!</h1>
			
			<p>To view this page you need to <a href="<?php echo wp_login_url($_SERVER['REQUEST_URI']); ?>">login</a></p>
			
		</div>
	</div>
</div>


<?php get_footer(); ?>