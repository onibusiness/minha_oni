
<!-- teste de archive-course -->
<?php get_header(); ?>


<?php if ( have_posts() ) : ?>

<?php sensei_load_template( 'loop-course.php' ); ?>

<?php else : ?>

<p><?php esc_html_e( 'No courses found that match your selection.', 'sensei-lms' ); ?></p>

<?php endif; // End If Statement ?>



<?php get_footer();?>   