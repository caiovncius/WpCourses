<?php 
	get_header();

	while ( have_posts()) : the_post();
?>
<div class="entry-content">
	<div class="wpc_course_title">
		<div class="container">
			<div class="course_img_featured col-md-3">
				<?php 
					if( has_post_thumbnail()) {			

						the_post_thumbnail ( array (300, 180));
					}
				?>	
			</div><!--- course_img_featured -->
			<div class="course_title_featured col-md-8">
			<h1><?php the_title(); ?></h1>
				<p>
					<?php get_hours ('<b>Horas:</b>', 'horas'); ?><br>
					<?php get_requirements('<b>Requisitos:</b>'); ?>	
				</p>
			</div><!--- course_title_featured -->
		</div>
	</div>
		<div class="row wpc_course_content">
			<div class="container">
				<div class="course_content col-md-8">
					<?php the_content(); ?>
				</div>
				<div class="course_sidebar col-md-4">
				
				</div>
			</div>			
		</div>

</div>
<?php
	endwhile;
	get_footer();
?>