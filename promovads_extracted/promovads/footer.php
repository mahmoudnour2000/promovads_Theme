	</div><!-- #content -->

<?php if ( promovads_get_demo_config() ) : ?>
	<?php get_template_part( 'template-parts/demos/_shared/footer' ); ?>
<?php else : ?>
	<?php get_template_part( 'template-parts/footers/footer-main' ); ?>
<?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
