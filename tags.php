<?php
/*
Template name: Indice por Etiquetas
*/
get_header(); ?>

        <section class='content__blog'>

            <header class="page-header">
                <h1 class="page-title">Etiquetas</h1>
            </header>

                <?php $tags = get_tags(); ?>

                <?php if($tags != NULL) {
                    $last_first = '';
                    ?>
            <article class='tag'>

                    <?php foreach ($tags as $tag) {
                        $first = substr(ucfirst($tag->name), 0, 1);	?>

                        <?php if ($last_first != $first) { ?>

                            <?php if ($last_first != '') { ?>

                </ul>
            </article>
            <hr/>
            <article class='tag'>

                        <?php } ?>

                        <?php $last_first = $first; ?>

                    <header class="entry-header">
                        <?php if($tag != NULL) { ?>
                    <h2 class="entry-title"><?php echo $first; ?></h2>
                        <?php } ?>
                </header><!-- .entry-header -->

                    <ul class="tag-list">

                        <?php } ?>

                        <?php $base_url = get_bloginfo('home') . "/tag/" . $tag->slug; ?>

                        <li><a href="<?php echo $base_url; ?>" title="<?php echo $tag->name; ?>"><?php echo $tag->name; ?></a></li>

                    <?php } ?>

                    </ul>
                </article>

                <?php } ?>

        </section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
