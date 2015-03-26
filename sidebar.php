<?php
/**
 * La plantilla del sidebar.
 */

?>
        <aside class='sidebar sidebar--portfolio'>

            <aside id='lifestream'>
                <nav>
                    <ul class='sidebar__lifestream'>
                        <li><a href='http://www.facebook.com/davidvalverde' title='Facebook'><i class='fa fa-facebook fa-2x'></i></a></li>
                        <li><a href='https://foursquare.com/davidvalverde' title='Foursquare'><i class='fa fa-foursquare fa-2x'></i></a></li>
                        <li><a href='https://github.com/davidvalverde' title='Github'><i class='fa fa-github fa-2x'></i></a></li>
                        <li><a href='http://www.google.com/profiles/dmvalverde' title='Google'><i class='fa fa-google-plus fa-2x'></i></a></li>
                        <li><a href='http://instagram.com/david.valverde' title='Instagram'><i class='fa fa-instagram fa-2x'></i></a></li>
                        <li><a href='http://www.linkedin.com/in/davidvalverde' title='Linkedin'><i class='fa fa-linkedin fa-2x'></i></a></li>
                        <li><a href='http://twitter.com/davidvalverde/' title='Twitter'><i class='fa fa-twitter fa-2x'></i></a></li>
                        <li><a href='http://www.youtube.com/user/dmvalverde' title='Youtube'><i class='fa fa-youtube fa-2x'></i></a></li>
                    </ul>
                </nav>
            </aside>

              <?php if (is_single()) : ?>
              <aside class="summary summary--blog">
                  <p><i class="fa fa-file"></i><a href='<?php echo get_permalink(); ?>' title='<?php the_title(); ?>'><?php the_title(); ?></a></p>
                  <p><i class="fa fa-calendar-o"></i><a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'), get_the_time('d')); ?>"><?php the_date('d F Y'); ?></a></p>
                  <p><i class="fa fa-user"></i><?php the_author_posts_link(); ?></p>
                  <p><i class="fa fa-folder-open"></i><?php echo get_the_category_list(', '); ?></p>
                  <p><i class="fa fa-tag"></i><?php the_tags(''); ?></p>
              </aside>
              <?php endif; ?>

            <?php if (is_category()) : ?>
              <aside class="summary summary--blog">
                  <h3><?php echo single_cat_title( '', false ); ?></h3>
                  <p><?php echo category_description(); ?></p>
              </aside>
              <?php endif; ?>

            <?php if (is_tag()) : ?>
              <aside class="summary summary--blog">
                  <h3><?php echo single_tag_title( '', false ); ?></h3>
                  <p><?php echo tag_description(); ?></p>
              </aside>
              <?php endif; ?>

            <?php if (is_author()) : ?>
              <aside class="summary summary--blog">
                  <div id="author-avatar">
                    <?php echo get_avatar(get_the_author_meta('user_email'), 40); ?>
                </div><!-- #author-avatar -->
                <h3><?php echo get_the_author(); ?></h3>
                <p><a href='<?php the_author_meta('user_url'); ?>' title='<?php the_author_meta('user_url'); ?>'><?php the_author_meta('user_url'); ?></a></p>
                  <p><?php the_author_meta('description'); ?></p>
              </aside>
              <?php endif; ?>

              <?php if (!is_home()) : ?>

              <hr>

              <aside id="recent-posts">
                  <header>
                      <h2>Últimos posts</h2>
                  </header>
                  <nav>
                      <ul class="fa-ul"><?php wp_get_archives('type=postbypost&limit=5&before=<i class="fa-li fa fa-file"></i>'); ?></ul>
                  </nav>
              </aside>

              <?php endif; ?>

              <hr>

            <aside id="most-commented">
                <header>
                    <h2>Lo + comentado</h2>
                </header>
                <nav>
                    <ul class="fa-ul"><?php dv3_most_commented_posts(5); ?></ul>
                </nav>
            </aside>

            <hr>

            <aside id="categories">
                <header>
                    <h2>Los temas del blog</h2>
                </header>
                <nav>
                    <ul class="fa-ul"><?php dv3_list_categories(); ?></ul>
                </nav>
            </aside>

            <hr>

            <aside id="archives">
                <header>
                    <h2>La Hemeroteca</h2>
                </header>
                <nav>
                    <ul class="fa-ul"><?php dv3_get_archive(); ?></ul>
                </nav>
            </aside>

            <hr>

            <aside id="tags">
                <header>
                    <h2>¿De qué se habla?</h2>
                </header>
                <nav>
                    <ul class="fa-ul"><?php dv3_tag_cloud(); ?></ul>
                </nav>
            </aside>

            <hr>

            <aside id="friends">
                <header>
                    <h2>Amigos</h2>
                </header>
                <nav>
                    <ul class="fa-ul"><?php dv3_blogroll(); ?></ul>
                </nav>
            </aside>

        </aside>