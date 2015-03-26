<?php
/*
Template name: Indice por Categoria
*/
get_header(); ?>

        <section class='content__blog'>

                <header class="page-header">
                    <h1 class="page-title">Categorías</h1>
                </header>

                <?php $cats = get_categories("hierarchical=0"); ?>

                <?php if($cats != NULL) { ?>

                    <?php foreach ($cats as $cat) { ?>
                        <header class="entry-header">
                            <?php if($cat != NULL) { $base_url = get_bloginfo('home') . "/category/" . $cat->slug; ?>
                                <h2 class="entry-title"><a href="<?php echo $base_url?>"><?php echo $cat->cat_name?></a></h2>
                            <?php } ?>
                        </header><!-- .entry-header -->

                        <p><?php echo $cat->category_description ?></p>

                        <?php $myposts = get_posts("numberposts=-1&category=$cat->cat_ID"); ?>
                        <ul class="fa-ul">
                        <?php foreach($myposts as $post) : ?>
                            <li><i class="fa-li fa fa-file"></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php endforeach; ?>
                        </ul>

                    <?php } ?>

                <?php } ?>

        </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>