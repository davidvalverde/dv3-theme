<?php
/**
 * La plantilla principal
 */

get_header(); ?>

        <section class='content__blog'>

            <?php if ( have_posts() ) : ?>

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content-excerpt', get_post_format() ); ?>

                <?php endwhile; ?>

                <?php dv3_content_nav( 'nav-below' ); ?>

            <?php else : ?>

                <article id="post-0" class="post no-results not-found">
                    <header class="entry-header">
                        <h1 class="entry-title">Sin datos</h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>Lo siento, pero no he encontrado lo que estabas buscando.</p>
                    </div><!-- .entry-content -->
                </article><!-- #post-0 -->

            <?php endif; ?>

        </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>