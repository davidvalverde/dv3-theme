<?php
/**
 * La plantilla para mostrar el contenido del extracto de un post.
 */
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title; ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="entry-meta">
                <?php dv3_posted_on(); ?>
            </div><!-- .entry-meta -->
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div><!-- .entry-content -->

        <footer class="entry-meta">
            <?php $show_sep = false; ?>
            <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
            <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list(', ');
                if ( $categories_list ):
            ?>
            <span class="cat-links">
                <?php printf('Publicado en <span class="%1$s">%2$s</span>', 'entry-utility-prep entry-utility-prep-cat-links', $categories_list ); ?>
            </span>
            <?php endif; // End if categories ?>
            <?php endif; // End if 'post' == get_post_type() ?>

            <?php if ( comments_open() ) : ?>
            <span class="sep"> | </span>
            <span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . 'Deja un comentario' . '</span>', '<b>1</b> Comentario', '<b>%</b> Comentarios'); ?></span>
            <?php endif; // End if comments_open() ?>

            <?php edit_post_link('Editar', '<span class="edit-link">', '</span>' ); ?>
        </footer><!-- #entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
