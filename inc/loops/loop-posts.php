<?php
global $posts, $settings;

if ( ! empty( $posts ) ) {
	global $post;
	foreach ( $posts as $post ) {
		setup_postdata( $post );
		?>
		<article id="post-<?php the_ID(); ?>" class="post">
			<header>
				<h2 class="post-title <?php echo ! isset( $settings['link'] ) || $settings['link'] ? 'link' : ''; ?>"
					<?php echo ! isset( $settings['link'] ) || $settings['link'] ? 'onclick="ajax_load_posts(this)"' : ''; ?>
				    data-url="<?php the_permalink(); ?>"
				    data-ID="<?php the_ID(); ?>">

					<span class="gutter-link">
						<?php echo mysql2date( 'M', $post->post_date ); ?><br/><?php echo mysql2date( 'j', $post->post_date ); ?>
					</span>
					<?php the_title(); ?>

				</h2>
				<?php jw_post_meta(); ?>
			</header>
			<div class="post-content">
				<?php the_post_thumbnail( 'full' ); ?>

				<?php
				if ( isset( $settings['excerpt'] ) && $settings['excerpt'] ) {
					the_excerpt();
				} else {
					the_content();
				}
				?>
			</div>
		</article>
	<?php
	}
	wp_reset_postdata();
} else {
	echo 'No posts found.';
}