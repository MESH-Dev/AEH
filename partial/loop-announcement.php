<?php
$sticky = get_option( 'sticky_posts' );
$args = array(
	'post_type' => 'alert',
	'posts_per_page'=> 3,
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
			'terms'    => array( 'home' ),
			'operator' => 'IN'
		),
	)
);
$query = new WP_Query($args);
if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post();
	$postType = get_post_type( get_the_ID() ); ?>

<div class="item <?php echo $postType; ?>">
	<div class="item-container">
		<?php echo get_field('heading'); ?>

		<p>
			<a class="read-more" href="<?php echo get_field('link'); ?>"><?php echo get_field('label'); ?></a>
		</p>
	</div>
</div>

<?php } } wp_reset_query(); ?>
