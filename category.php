<?php
/**
 * La plantilla para la página de una categoría.
 */

get_header(); ?>

        <section class='content__blog'>

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title"><?php echo single_cat_title( '', false ); ?></h1>
                </header>

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php
                        get_template_part( 'content-excerpt', get_post_format() );
                    ?>

                <?php endwhile; ?>

                <?php dv3_content_nav( 'nav-below' ); ?>

            <?php else : ?>

                <article id="post-0" class="post no-results not-found">
                    <header class="entry-header">
                        <h2 class="entry-title">Sin datos</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>Lo siento, pero no ha sido encontrado ningún post para la categoría indicada.</p>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->

            <?php endif; ?>

        </section><!-- #blog-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
