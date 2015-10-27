<div class="container home">
	<div class="nine columns">

		<div class="frame oneperframe" id="oneperframe">
			<ul class="clearfix">

					<?php

					$i = 0;
					$n = 5;

					?>

					<?php if ($i % $n == 0) { echo "<li>"; } ?>

						<?php get_template_part( 'partial/loop', 'announcement' ); ?>

					<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
					<?php $i++; ?>

					<?php if ($i % $n == 0) { echo "<li>"; } ?>

						<?php get_template_part( 'partial/loop', 'sticky' ); ?>

					<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
					<?php $i++; ?>

					<?php
					$sticky = get_option('sticky_posts');
					query_posts( array(
						'posts_per_page' => 25,
						'post_type' => array('policy','quality','education','institute','post','general'),

								'meta_key' => 'sticky_topic',
								'meta_value' => 'home',
								'meta_compare' => '!='

					) );
					if ( have_posts() ) while ( have_posts() ) : the_post();
						$postType = get_post_type( get_the_ID() );

						//check post type and apply a color
						if($postType == 'policy' || $postType == 'general'){
							$postColor = 'redd';
						}else if($postType == 'quality'){
							$postColor = 'greenn';
						}else if($postType == 'education' || $postType == 'webinar'){
							$postColor = 'grayy';
						}else if($postType == 'institute'){
							$postColor = 'bluee';
						}else if($postType == 'post'){
							$postColor = 'blog';
							$postType = 'blog';
						}else{
							$postColor = 'bluee';
						}
					?>

					<?php if ($i % $n == 0) { echo "<li>"; } ?>

						<div class="item <?php echo $postColor; ?>  <?php echo $postType; ?>-item">
							<div class="item-container">
			    			<div class="item-icon">
			    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
			    					if($terms){
				    					$termLink = get_term_link($terms[0], 'series');
					    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
				    				}
			    				?>

				    			<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" />
			    			</div>

		    				<h2><a href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"><?php the_title(); ?></a></h2>
		    				<p>
									<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
			    				<span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author();?></a></span>
								</p>


				    			<?php if(get_field('link_to_media') != 0){ ?>
									<a href="<?php the_field('uploaded_file'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-doc.png" /></a>
									<p><?php $exc = get_the_excerpt();
									$line=$exc;
									if(preg_match('/^.{1,100}\b/s', $exc, $match)){$line=$match[0];}
									$long_exc = get_field('long_excerpt');
									if($long_exc){echo $long_exc;}else{echo $exc;} ?></p>
									<p><a class="read-more" href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"> view more » </a></p>

								<?php }else{ ?>

									<p><?php $exc = get_the_excerpt();
									$line=$exc;
									if (preg_match('/^.{1,100}\b/s', $exc, $match)){$line=$match[0];}
									$long_exc = get_field('long_excerpt');
									if($long_exc){echo $long_exc;}else{echo $exc;} ?></p>
									<p><a class="read-more" href="<?php the_permalink(); ?>"> view more » </a></p>

								<?php } ?>

			    			<div class="item-tags">
			    				<?php $tags = get_the_terms(get_the_ID(),'post_tag');
			    					if($tags){
			    						$cnt = 0;
			    						foreach($tags as $tag)
			    						{
				    						$tagLink = get_term_link($tag->term_id,'post_tag');
				    						$tagSlug = $tag->slug;
				    						$tagSlug = str_replace('-',' ', $tagSlug);
				    						if ($cnt != 0) echo ", ";
					    					echo "<a href='".$tagLink."'>".$tagSlug."</a>";
					    					$cnt++;
					    				}
				    				} ?>
			    			</div>

			    		</div>
			  		</div>

					<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
					<?php $i++; ?>

				<?php endwhile; wp_reset_query();?>

			</ul>
		</div>
	</div>

	<div class="three columns">
		<div class="side">
			<div class="side-container">
				<div class="twitter">
					<?php display_user_tweets('OurHospitals',1); ?>
				</div>

				<div class="newsletter">


				 <?php dynamic_sidebar('Constant Contact'); ?>

						<!--<form>
							<span>Essential news in your inbox: </span>  -->
							<?php //echo do_shortcode('[constantcontactapi formid="1" lists="1"]'); ?>

							 <!--<input type="text" class="newsletter_btn_input" value="Enter Your Email"><input class="newsletter_btn" type="submit" > -->
						 <!-- <div class="clear"></div>
						</form>
						-->
						<div class="clear"></div>
				</div>

				<div class="topics">
					<h3> Top Issues and Topics</h3>
					<ul>
			<?php
				$taxonomies = array('educationtopics','policytopics','institutetopics','qualitytopics');
				$args = array(
						'orderby'       => 'count',
						'order'         => 'ASC',
						'hide_empty'    => true,
						'exclude'       => array(),
						'exclude_tree'  => array(),
						'include'       => array(),
						'number'        => '',
						'fields'        => 'all',
						'slug'          => '',
						'parent'         => '',
						'hierarchical'  => true,
						'child_of'      => 0,
						'get'           => '',
						'name__like'    => '',
						'pad_counts'    => false,
						'offset'        => '',
						'search'        => '',
						'cache_domain'  => 'core'
				);
				$terms = get_terms($taxonomies,$args);
				$count = 0;
				foreach($terms as $term){
					if($count < 7){ ?>
					<li><a href="<?php echo get_term_link($term); ?>"><?php echo $term->name; ?></a></li>
				<?php } $count++; } ?>
					</ul>
				</div>

			</div>
		</div>
	</div>
</div>
