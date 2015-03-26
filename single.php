<?php
/**
 * La plantilla para mostrar los posts individuales
 */

get_header(); ?>

            <section class='content__blog'>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'single' ); ?>

                    <?php comments_template( '', true ); ?>

                <?php endwhile; // end of the loop. ?>

        </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>