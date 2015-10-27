<div class="container action">
			<div class="three columns">
				<div class="gutter">
					<span class="filterby">Filter By Topic >></span><div class="going-mobile" id="page-filters">Filter By Topic &raquo;</div>
					<?php
						$args = array(
						    'orderby'       => 'name',
						    'order'         => 'ASC',
						    'hide_empty'    => false,
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
						$terms = get_terms( 'policytopics', $args );
						if(count($terms) > 0){ ?>
							<ul id="pagefilter" data-query="policy">
							<?php foreach($terms as $term){ ?>
								<li data-filter="<?php echo $term->slug; ?>"><a><?php echo $term->name; ?></a></li>
							<?php } ?>
								<li class="last"><a>Show All Topics</a></li>
							</ul>
						<?php } ?>
				</div>
			</div>
			<div class="nine columns">
				<div class="frame oneperframe" id="oneperframe">
					<ul class="clearfix">

							<?php

							$i = 0;
							$n = 5;

							?>

							<?php
							$sticky = get_option( 'sticky_posts' );
							$args = array(
								'post_type'    => 'alert',
								'post_count'   => 1,
								'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'category',
										'field' => 'slug',
										'terms' => array( 'policy' )
									),
									array(
										'taxonomy' => 'series',
										'field'	   => 'slug',
										'terms'    => 'alerts',
										'operator' => 'NOT IN'
									)
								)
							);
							$query = new WP_Query($args);
							if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
								$postType = get_post_type( get_the_ID() ); ?>

									<?php if ($i % $n == 0) { echo "<li>"; } ?>

									<div class="item">
										<div class="item-container">
											<?php echo get_field('heading'); ?>
						    			<p><a href="<?php echo get_field('link'); ?>" class="read-more"><?php echo get_field('label'); ?></a></p>
										</div>
									</div>

									<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
									<?php $i++; ?>

							<?php } } wp_reset_query(); ?>

							<?php $args = array(
									'post_type' => 'policy',
									'series' => 'alerts',
									'posts_per_page' => 4,
									'tax_query' => array(
										array(
											'taxonomy' => 'series',
											'field'	   => 'slug',
											'terms'    => 'updates',
											'operator' => 'NOT IN'
										)
									)
								);

								$alerts = get_posts($args);
								if($alerts){ ?>

								<?php if ($i % $n == 0) { echo "<li>"; } ?>

									<div class="item <?php echo $postType; ?>-item">
										<div class="item-container">
											<h2>Action Alerts</h2>

											<div class="item-icon">
												<a href='<?php echo get_term_link( 'updates', 'series' ); ?>'>Action Alerts</a> <img src="<?php bloginfo('template_directory'); ?>/images/icon-policy.png" />
											</div>

											<ul class="item-linklist">
												<?php foreach($alerts as $post){
														setup_postdata($post); ?>
														<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
												<?php } wp_reset_postdata(); ?>
											</ul>

											<p><a class="read-more" href='<?php echo get_term_link( 'updates', 'series' ); ?>'>All Action Alerts &raquo;</a></p>
										</div>
									</div>

								<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
								<?php $i++; ?>

							<?php } ?>

							<?php
							$args = array(
								'post_type' => array('policy'),
								'meta_key' => 'sticky_topic',

								'meta_value' => 'policy',
								'meta_compare' => '='
							);
							$query = new WP_Query($args);
							if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
								$postType = get_post_type( get_the_ID() );

									//check post type and apply a color
									if($postType == 'policy'){
										$postColor = 'redd';
									}else if($postType == 'quality'){
										$postColor = 'greenn';
									}else if($postType == 'education'){
										$postColor = 'grayy';
									}else if($postType == 'institute'){
										$postColor = 'bluee';
									}else{
										$postColor = 'bluee';
									} ?>

									<?php if ($i % $n == 0) { echo "<li>"; } ?>

										<div class="item <?php echo $postType; ?>-item">
											<div class="item-container">
							    			<div class="item-icon"><img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" /></div>

						    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

						    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
						    				<span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author(); ?></a></span>

							    			<p><?php if(get_field('long_excerpt')){ the_field('long_excerpt'); } else { the_excerpt();} ?> <a class="more" href="<?php the_permalink(); ?>"> view more » </a>
							    			</p>

							    			<div class="item-tags">
							    				 <?php //the_tags(' ',' ',' '); ?>
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
								    				}?>
							    			</div>
											</div>
							  		</div>

								<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
								<?php $i++; ?>

						<?php } } wp_reset_query(); ?>

							<?php
							$today = mktime(0, 0, 0, date('n'), date('j'));
							$args = array(
								'post_type' => 'webinar',
								'posts_per_page' => 1,
								'order' => 'asc',
								'post_status' => 'all',
								'meta_query'  => array(
									array(
										'key' => 'webinar_date',
										'value' => $today,
										'compare' => '>='
									)
								),
								'tax_query' => array(
									array(
										'taxonomy' => 'webinartopics',
										'field' => 'slug',
										'terms' => 'policy'
									)
								),
								'orderby' => 'meta_value',
								'meta_key' => 'webinar_date',
							);
							query_posts( $args ); if(have_posts()){ while ( have_posts() ) { the_post();
							?>

							<?php if ($i % $n == 0) { echo "<li>"; } ?>

								<div class="item">

				    			<div class="item-icon"> Upcoming Webinar
				    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-policy.png" />
				    			</div>

			    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			    				<span class="item-date"><?php echo date('M j, Y', get_field('webinar_date')); ?></span>

				    			<p><?php
									$exc = get_the_excerpt();
									$line=$exc;
									if (preg_match('/^.{1,100}\b/s', $exc, $match))
									{
									    $line=$match[0];
									}
									echo $exc; ?>

									<a class="more" href="<?php the_permalink(); ?>"> view more » </a>
				    			</p>
				    			<span class="reserve button redd policy"><a href="<?php the_field('registration_link'); ?>">Reserve Your Spot</a></span>
				    			<div class="item-tags">
				    				<?php //the_tags(' ',' ',' '); ?>
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
				    				}?>
				    			</div>

					  		</div>

								<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
								<?php $i++; ?>


						<?php } } wp_reset_query();?>


						<?php
							query_posts( array(
								'post_type' =>  'policy',
								'policytopics' => '',
								'meta_query' => array(
									array(
										'key' => 'sticky_topic',
										'meta_value' => 'policy',
										'compare' => 'IN'
									)
								),
								'date_query' => array(
									array(
										'column' => 'post_date_gmt',
										'after'  => '2 weeks ago',
									)
								)
							) );
							if ( have_posts() ) while ( have_posts() ) : the_post();
								$postType = get_post_type( get_the_ID() );

								//check post type and apply a color
								if($postType == 'policy'){
									$postColor = 'redd';
								}else if($postType == 'quality'){
									$postColor = 'greenn';
								}else if($postType == 'education'){
									$postColor = 'grayy';
								}else if($postType == 'institute'){
									$postColor = 'bluee';
								}else{
									$postColor = 'bluee';
								}
							?>

							<?php if ($i % $n == 0) { echo "<li>"; } ?>

								<div class="item <?php echo $postColor; ?>  <?php echo get_post_type( get_the_ID() ); ?>-item">
				    			<div class="item-icon">
				    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
				    					if($terms){
					    					$termLink = get_term_link($terms[0], 'series');
						    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
					    				}
				    				?>
				    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" />
				    			</div>

			    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			    				<span class="item-date"><?php the_time('M j, Y'); ?> ||</span>
			    				<span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author(); ?></a></span>
				    			<p><?php
									$exc = get_the_excerpt();
									$line=$exc;
									if (preg_match('/^.{1,100}\b/s', $exc, $match))
									{
									    $line=$match[0];
									}
									echo $exc; ?>

				    			</p>
				    			<a class="more" href="<?php the_permalink(); ?>"> view more » </a>
				    			<div class="item-tags">
				    				<?php //the_tags(' ',' ',' '); ?>

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
				    				}?>
				    			</div>
				  			</div>

							<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
							<?php $i++; ?>

						<?php endwhile; wp_reset_query();?>


						<?php $sterms = get_terms('policytopics',array('fields'=>'ids'));?>
						<?php
						query_posts( array(
							'post_type' =>  array('post','policy'),
							'meta_query' => array(
								array(
									'key' => 'sticky_topic',
									'meta_value' => 'policy',
									'compare' => 'NOT LIKE'
								)
							),
							'tax_query'    => array(
								array(
									'taxonomy' => 'policytopics',
									'field'	   => 'id',
									'terms'    => $sterms
								)
							)
						) );
						if ( have_posts() ) while ( have_posts() ) : the_post();
							$postType = get_post_type( get_the_ID() );

							//check post type and apply a color
							if($postType == 'policy'){
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

								<div class="item <?php echo $postType; ?>-item">
									<div class="item-container">

					    			<div class="item-icon">
					    				<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
					    					if($terms){
						    					$termLink = get_term_link($terms[0], 'series');
							    				echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
						    				}
					    				?>
										<?php if($postType != 'post'){ ?>
						    				<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo $postType; ?>.png" />
					    				<?php } ?>
					    			</div>

				    				<h2><a href="<?php if(get_field('link_to_media')){the_field('uploaded_file');}else{the_permalink();} ?>"><?php the_title(); ?></a></h2>
						    		<p><span class="item-date"><?php the_time('M j, Y'); ?></span> || <span class="item-author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>/?prof=article"><?php the_author(); ?></a></span></p>

						    			<?php if(get_field('link_to_media')){ ?>
											<a href="<?php the_field('uploaded_file'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/<?php echo $postType; ?>-doc.png" /></a>
										<?php }else{ ?>
											<p><?php
											$exc = get_the_excerpt();
											$line=$exc;
											if (preg_match('/^.{1,100}\b/s', $exc, $match))
											{
											    $line=$match[0];
											}
											echo $exc; ?>

											<a class="more" href="<?php the_permalink(); ?>"> view more » </a>

										</p>

										<?php } ?>
						    			<div class="item-tags">
						    				<?php //the_tags(' ',' ',' '); ?>
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
						    				}?>
						    			</div>

						  		</div>
								</div>

							<?php if ($i % $n == ($n - 1)) { echo "</li>"; } ?>
							<?php $i++; ?>

						<?php endwhile; wp_reset_query();?>
					</ul>
				</div>
			</div>
</div>
