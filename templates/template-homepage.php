<?php /*
 * Template Name: Homepage Template
 */
?>
<?php get_header(); ?>
<div id="banner" class="fullwidth g1">
		<!--<div class="container">-->
			<div class="sixteen columns featured">

			<div class="container" id="bannerAb">
				<div id="banner_text">
			        <span class="orange">
			          <em>Essential People</em><br />
			          <em>Essential Communities</em> <br />
			          <span class="bold">Essential Hospitals</span>
			        </span>
 					 <span class="secondary"><a href="<?php bloginfo('url') ?>/our-inspiration">These are the faces<br>and stories behind<br>our essential hospitals<br>across the country </a></span>

			      </div>
			</div>



	  <div id="people">
		  <?php
		  $args = array(
		  	'posts_per_page' => -1,
		  	'orderby' => 'rand',
		  	'post_type' => 'story'
		  );
		  $query = get_posts($args);
		  foreach($query as $post) {
			  setup_postdata($post); ?>

			  <a class="people_box" href="<?php echo get_permalink(12084); ?>/?loc=<?php echo $post->ID; ?>">
				<?php $image = wp_get_attachment_image_src( get_field('portrait'), 'story-home' );?>
	        	<img src="<?php echo $image[0]; ?>" id="starter" />
	        	<div class="p_hover">
	        		<div class="p_name">
	        			<!--<span class="p_georgia">Name: </span>!--> <?php the_title(); ?>
	        		</div>

	        		<div class="p_info">
						<span class="p_occupation"><!--<span class="p_georgia">Occupation:</span>!--> <?php echo get_field('occupation'); ?></span>
						<span class="p_hospital"><!--<span class="p_georgia">Hospital: </span>!--> <?php echo get_field('hospital'); ?></span>
					</div>

					<?php if(get_field('legacy_home')){ ?>
						<p><!--<span class="p_georgia">Legacy: </span>!-->  <?php echo get_field('legacy_home'); ?></p>
					<?php }else{ ?>
						<p><!--<span class="p_georgia">Legacy: </span>!-->  <?php echo get_field('legacy_cond'); ?></p>
					<?php } ?>
	        	</div>
	        </a>
		  <?php	} wp_reset_postdata(); ?>
	  </div>


			</div>
		<!--</div>-->

		<div class="clear"></div>
	</div><!-- End of featured -->

<div id="postFeatured">
	<div class="container fullborder">

 		<div class="twelve columns filters">
 			<span> FILTER BY &rsaquo;&rsaquo;</span>
 			<div id="red_btn" data-filter="policy" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/policy.png"> <span>Action</span>
 			</div>
 			<div id="green_btn" data-filter="quality" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/quality.png"> <span>Quality</span>
 			</div>
 			<div id="gray_btn" data-filter="education" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/edu.png"> <span>Education</span>
 			</div>
 			<div id="blue_btn" data-filter="institute" class="filter_btn ">
 				<img src="<?php bloginfo('template_directory'); ?>/images/inst.png"> <span>Institute</span>
 			</div>
 			<div id="all" data-filter="*" class="filter_btn all"><span>Reset</a></div>
 		</div>
 	</div>

	<?php get_template_part('partial/template','homeloop'); ?>

	<div id="prev" title="Show previous"> </div>
	<div id="next" title="Show more Articles"> </div>

	<a id="prevbtn" title="Show previous">  </a>
	<a id="nextbtn" title="Show more">  </a>
</div>

<?php get_footer(); ?>
