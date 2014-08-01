<footer id="site-footer" class="row">
	<div class="footer-widgets columns large-12">

		<div class="row">
			<?php for ( $i = 1; $i <= 4; $i++ ) { ?>
				<div class="footer-widget columns large-3 medium-6 small-12">
					<?php dynamic_sidebar( "footer-$i" ); ?>
				</div>
			<?php } ?>
		</div>

	</div>
</footer>

</div><!--#wrapper-->

<?php wp_footer(); ?>

</body>
</html>