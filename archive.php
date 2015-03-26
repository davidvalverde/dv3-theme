<?php
/**
 * La plantilla para la página de archivo.
 */

get_header(); ?>

        <section class='content__blog'>

            <?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title">
                        <?php if ( is_day() ) : ?>
                            <?php echo get_the_date(); ?>
                        <?php elseif ( is_month() ) : ?>
                            <?php echo get_the_date( 'F Y' ); ?>
                        <?php elseif ( is_year() ) : ?>
                            <?php echo get_the_date( 'Y' ); ?>
                        <?php else : ?>
                            <?php echo "Hemeroteca"; ?>
                        <?php endif; ?>
                    </h1>
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
                        <h1 class="entry-title">Sin datos</h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>Lo siento, pero no ha sido encontrado ningún post para la fecha indicada.</p>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->

            <?php endif; ?>

        </section><!-- #content-blog -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>