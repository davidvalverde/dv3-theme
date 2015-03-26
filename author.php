<?php
/**
 * La plantilla para la página de un autor.
 */

get_header(); ?>

        <section class='content__blog'>

            <?php if ( have_posts() ) : ?>

                <?php
                    /* Queue the first post, that way we know
                     * what author we're dealing with (if that is the case).
                     *
                     * We reset this later so we can run the loop
                     * properly with a call to rewind_posts().
                     */
                    the_post();
                ?>

                <header class="page-header">
                    <h1 class="page-title author"><?php echo get_the_author(); ?></h1>
                </header>

                <?php
                    /* Since we called the_post() above, we need to
                     * rewind the loop back to the beginning that way
                     * we can run the loop properly, in full.
                     */
                    rewind_posts();
                ?>

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
                        <p>Lo siento, pero no ha sido encontrado ningún post del autor indicado.</p>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->

            <?php endif; ?>

        </section><!-- #content-blog -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>