<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php $speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="quality" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">

				<h3><span class="greenn">QUALITY</span><br><?php the_field('bannerTitle'); ?></h3>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>
<div id="contentWrap" class="quality">
	<div id="prev" title="Show previous"> </div>
	<div id="next" title="Show more Articles"> </div>

	<a id="prevbtn" title="Show previous">  </a>
	<a id="nextbtn" title="Show more">  </a>
	<div class="gutter">
		<div class="container">
			<?php
				if(has_nav_menu('primary-menu')){
					$defaults = array(
						'theme_location'  => 'primary-menu',
						'menu'            => 'primary-menu',
						'container'       => 'div',
						'container_class' => '',
						'container_id'    => 'pageNav',
						'menu_class'      => 'quality',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 2,
						'walker'          => ''
					); wp_nav_menu( $defaults );
				}
			?>
			<div id="breadcrumbs">
				<ul>
					<li><a href="<?php echo home_url(); ?>">Home</a>
						<?php
						$defaults = array(
						'theme_location'  => 'primary-menu',
						'menu'            => 'primary-menu',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'menu',
						'menu_id'         => '',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 0,
						'walker'          => ''
					); wp_nav_menu( $defaults ); ?>
					</li>
				</ul>

				<a href="<?php echo site_url('/feed/?post_type=quality'); ?>" target="_blank">
					<div id="rssFeedIcon" class="quality">
						Subscribe
					</div>
				</a>

			</div>
			<div id="contentPrimary" style="width:100%">
				<?php get_template_part( 'partial/template', 'qualityloop' ); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
