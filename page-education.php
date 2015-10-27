<?php get_header();
while ( have_posts() ) : the_post();
$speakerIMG = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
<div id="featured-img" class="education" style="background-image:url(<?php echo $speakerIMG; ?>);">
	<div class="container">
		<div id="featured-intro">
				<h3><?php the_field('bannerTitle'); ?></h3>
				<h4><?php the_field('bannerDescription'); ?></h4>
			<?php endwhile; // end of the loop. ?>
		</div>
	</div>
</div>


	<div class="container education">
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

			<a href="<?php echo site_url('/feed/?post_type=webinar'); ?>" target="_blank">
				<div id="rssFeedIcon" class="education">
					Subscribe
				</div>
			</a>
		</div>

				<div class="nine columns">
					<div class="frame oneperframe" id="oneperframe">
						<ul class="clearfix">
							<li>

								<?php while ( have_posts() ) : the_post(); ?>
								<div class="item">
									<div class="item-container">
										<div class="item-icon">About Essential Hospitals Education
											<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
										</div>
										<?php the_content(); ?>
									</div>

								</div>
								<?php endwhile; ?>


								<div class="item">
									<div class="item-container">
										<div class="item-icon">Archived Webinars
											<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
										</div>

										<ul class="item-linklist">

											<?php $today = mktime(0, 0, 0, date('n'), date('j'));
											$args = array(
												'post_type' => 'webinar',
												'posts_per_page' => 3,
												'order' => 'desc',
												'post_status' => 'all',
												'meta_query'  => array(
													array(
														'key' => 'webinar_date',
														'value' => $today,
														'compare' => '<='
													)
												),
												'orderby' => 'meta_value',
												'meta_key' => 'webinar_date',
											);
											$query = new WP_Query($args);
											if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
											$postType = get_the_terms($post, 'webinartopics');
											$typeArr = array();
											if($postType){
												foreach($postType as $type){
													array_push($typeArr, $type->slug);
												}
											}
											//check post type and apply a color
											if(in_array('policy', $typeArr)){
												$postColor = 'redd';
											}else if(in_array('quality', $typeArr)){
												$postColor = 'greenn';
											}else if(in_array('education', $typeArr)){
												$postColor = 'grayy';
											}else if(in_array('institute', $typeArr)){
												$postColor = 'bluee';
											}else{
												$postColor = 'bluee';
											} ?>

											<li>
												<div class="title <?php echo $postColor; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div><span class="excerpt"><?php $exc = get_the_excerpt(); echo substr($exc, 0, 50); ?>...</span>
											</li>

											<?php }
											echo '<a class="read-more" href="'.get_post_type_archive_link('webinar').'/?timeFilter=publish">All Recorded Webinars &raquo;</a>';
											} ?>

										</ul>
									</div>
								</div>

						<?php
							$args = array(
								'post_type' => 'alert',
								'posts_per_page'=> 6,
								'orderby'   => 'date',
								'order'     => 'asc',
								'tax_query' => array(
									'relation' => 'AND',
									array(
										'taxonomy' => 'category',
										'field'    => 'slug',
										'terms'    => array('announcements'),
										'operator' => 'IN'
									),
									array(
										'taxonomy' => 'category',
										'field'    => 'slug',
										'terms'    => array( 'education' ),
										'operator' => 'IN'
									),
									array(
										'taxonomy' => 'category',
										'field'    => 'slug',
										'terms'    => array( 'updates' ),
										'operator' => 'NOT IN'
									)
								)
							);
							$query = new WP_Query($args);
							if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post(); ?>
								<div class="item">
									<div class="item-container">
										<div class="item-icon">Updates
											<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
										</div>

										<h2><a href="<?php the_field('link'); ?>"><?php the_field('heading'); ?></a></h2>
										<a href="<?php the_field('link'); ?>" class="read-more"><?php the_field('label'); ?> &raquo;</a>

									</div>
								</div>
						<?php } } wp_reset_query(); ?>


						<?php
						$layoutArray = array('tall','short');
						$args = array(
							'post_type' => array('policy','institute','quality'),
							'meta_query' => array(
								'relation' => 'OR',
								array(
									'key' => 'sticky_topic',
									'value' => 'ehu',
									'compare' => 'LIKE'
								),
								array(
									'key' => 'sticky_topic',
									'value' => 'education',
									'compare' => 'LIKE'
								)
							)
						);
						$query = new WP_Query($args);
						if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
							$rand_key = array_rand($layoutArray, 1);
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

								<div class="item">
									<div class="item-container">
										<div class="item-icon">
											<?php $terms = wp_get_post_terms(get_the_ID(), 'series');
												if($terms){
													$termLink = get_term_link($terms[0], 'series');
													echo "<a href='".$termLink."'>".$terms[0]->name."</a>";
												}
											?>
											<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
											<img src="<?php bloginfo('template_directory'); ?>/images/icon-<?php echo get_post_type( get_the_ID() ); ?>.png" />
										</div>
									</div>

			    				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			    				<p><span class="item-date"><?php the_time('M j, Y'); ?> ||</span><span class="item-author"><?php the_author(); ?></span></p>

				    			<p><?php $exc = get_the_excerpt(); echo $exc; ?><a class="more" href="<?php the_permalink(); ?>"> view more » </a>
				    			</p>
				    			<div class="item-tags">
				    				<?php the_tags(' ',' ',' '); ?>
				    			</div>

					  		</div>

						<?php } } ?>





						<div class="item">
							<!--  Upcoming Events Box -->

							<div class="item-container">

								<div class="item-icon">Upcoming Events
									<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
								</div>

								<?php
								$today = mktime(0, 0, 0, date('n'), date('j'));
								$args = array(
									'post_type' => 'events',
									'posts_per_page' => 3,
									'order' => 'asc',
									'post_status' => 'publish',
									'meta_query'  => array(
										array(
											'key' => 'date',
											'value' => $today,
											'compare' => '>='
										)
									),
									'orderby' => 'meta_value',
									'meta_key' => 'date',
								);
								$query = new WP_Query($args);

								if ( $query->have_posts() ) { while ( $query->have_posts() ) {
									$query->the_post();
									$postType = get_field('section');
									$date = get_post_meta( get_the_ID(), 'date', 'true');
									//check post type and apply a color
									if($postType =='policy'){
										$postColor = 'redd';
									}else if($postType =='quality'){
										$postColor = 'greenn';
									}else if($postType =='education'){
										$postColor = 'grayy';
									}else if($postType =='institute'){
										$postColor = 'bluee';
									}else{
										$postColor = 'redd';
									} ?>



									<h2 class="title <?php echo $postColor; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><span class="date"><?php echo date('M j, Y', $date);?></span> | <span class="excerpt"><?php $exc = get_the_excerpt(); echo substr($exc, 0, 50); ?>...</span></p>

								<?php }
								echo '<a class="read-more" href="'.get_post_type_archive_link('events').'/?timeFilter=future">All Upcoming Events &raquo;</a>';
								} ?>

							</div>
						</div>

						<div class="item">
							<div class="item-container">

								<div class="item-icon">Upcoming Webinars
									<img src="<?php bloginfo('template_directory'); ?>/images/icon-education.png" />
								</div>

								<?php
									$today = mktime(0, 0, 0, date('n'), date('j'));
									$args = array(
										'post_type' => 'webinar',
										'posts_per_page' => 3,
										'order' => 'asc',
										'post_status' => 'all',
										'meta_query'  => array(
											array(
												'key' => 'webinar_date',
												'value' => $today,
												'compare' => '>='
											)
										),
										'orderby' => 'meta_value',
										'meta_key' => 'webinar_date',
									);
								$query = new WP_Query($args);
								if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
								$postType = get_the_terms($post, 'webinartopics');
								$typeArr = array();
								if($postType){
									foreach($postType as $type){
										array_push($typeArr, $type->slug);
									}
								}
								//check post type and apply a color
								if(in_array('policy', $typeArr)){
									$postColor = 'redd';
								}else if(in_array('quality', $typeArr)){
									$postColor = 'greenn';
								}else if(in_array('education', $typeArr)){
									$postColor = 'grayy';
								}else if(in_array('institute', $typeArr)){
									$postColor = 'bluee';
								}else{
									$postColor = 'bluee';
								} ?>

								<p>
									<h2 class="title <?php echo $postColor; ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<p><span class="date"><?php echo date('M j, Y', get_field('webinar_date')); ?></span> | <span class="excerpt"><?php $exc = get_the_excerpt(); echo substr($exc, 0, 50); ?>...</span></p>
								</p>

								<?php }
								echo '<a class="read-more" href="'.get_post_type_archive_link('webinar').'/?timeFilter=future">All Upcoming Webinars &raquo;</a>';
								} ?>

							</div>
						</div>

						</li>
					</ul>
				</div>
			</div>



				<div class="three columns">
					<div class="side">
						<div class="item">
							<div class="side-container">

									<?php if(!is_user_logged_in()){ ?>

											<h2>Dashboard Sign-In</h2>
											 <?php $args = array(
									        'echo' => true,
									        'redirect' => site_url( $_SERVER['REQUEST_URI'] ),
									        'form_id' => 'loginform',
									        'label_username' => __( 'Username' ),
									        'label_password' => __( 'Password' ),
									        'label_remember' => __( 'Remember Me' ),
									        'label_log_in' => __( '&raquo;' ),
									        'id_username' => 'user_login',
									        'id_password' => 'user_pass',
									        'id_remember' => 'rememberme',
									        'id_submit' => 'wp-submit',
									        'remember' => false,
									        'value_username' => NULL,
									        'value_remember' => false );
									        wp_login_form($args); ?>
									<?php }else{
										$currentUser = get_current_user_id();
										$user_info = get_userdata($currentUser);
										$user_avatar = get_avatar($currentUser);
									?>

									<?php include(locate_template('/membernetwork/module-dashProfile.php')); ?>
									<?php } ?>

								</div>
							</div>

							<div class="item">
								<div class="side-container">

									<h2>Ask a Question</h2>
									<p>Contact our team with questions or suggestions regarding education and training opportunities.</p>
									<?php echo do_shortcode('[formidable id=6]'); ?>

								</div>
							</div>
						</div>
					</div>
				</div>


<?php get_footer(); ?>
