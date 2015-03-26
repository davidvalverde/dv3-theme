<?php
/**
 * Funciones auxiliares.
 */

/**
 * Inicializa la longitud en palabras de los extractos de los posts.
 */
function dv3_excerpt_length( $length ) {
    return 75;
}
add_filter( 'excerpt_length', 'dv3_excerpt_length' );

/**
 * Devuelve un link "Seguir leyendo..." para los extractos de los posts.
 */
function dv3_continue_reading_link() {
    return ' <a href="'. esc_url( get_permalink() ) . '" title="' . get_the_title() . '">' . 'Seguir leyendo <i class="fa fa-fw fa-angle-double-right"></i>' . '</a>';
}

/**
 * Reemplaza "[...]" (añadido automáticamente con los extractos generados) por el texto indicado.
 */
function dv3_auto_excerpt_more( $more ) {
    return ' &hellip;' . dv3_continue_reading_link();
}
add_filter( 'excerpt_more', 'dv3_auto_excerpt_more' );

/**
 * Añade un "Seguir leyendo" a los extractos de los posts customizados.
 */
function dv3_custom_excerpt_more( $output ) {
    if ( has_excerpt() && ! is_attachment() ) {
        $output .= dv3_continue_reading_link();
    }
    return $output;
}
add_filter( 'get_the_excerpt', 'dv3_custom_excerpt_more' );

/**
 * Muestra una navegación adelante/atrás en páginas cuando es necesario.
 */
function dv3_content_nav( $nav_id ) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $nav_id; ?>">
            <?php wp_pagenavi(); ?>
        </nav><!-- #nav-above -->
    <?php endif;
}

if ( ! function_exists( 'dv3_comment' ) ) :
/**
 * Plantilla para comentarios y pingbacks.
 */
function dv3_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
        <p>Pingback <?php comment_author_link(); ?><?php edit_comment_link('Editar', '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php
                        $avatar_size = 68;
                        if ( '0' != $comment->comment_parent )
                            $avatar_size = 39;

                        echo get_avatar( $comment, $avatar_size );

                        /* translators: 1: comment author, 2: date and time */
                        printf('%1$s a %2$s <span class="says">dijo:</span>',
                            sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                            sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                esc_url( get_comment_link( $comment->comment_ID ) ),
                                get_comment_time( 'c' ),
                                /* translators: 1: date, 2: time */
                                sprintf('%1$s a las %2$s', get_comment_date(), get_comment_time() )
                            )
                        );
                    ?>

                    <?php edit_comment_link('Editar', '<span class="edit-link">', '</span>' ); ?>
                </div><!-- .comment-author .vcard -->

                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation">Tu comentario está en espera para ser moderado por el Administrador.</em>
                    <br />
                <?php endif; ?>

            </footer>

            <div class="comment-content"><?php comment_text(); ?></div>

            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => 'Responder <i class="fa fa-fw fa-arrow-down"></i>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->

    <?php
            break;
    endswitch;
}
endif; // ends check for dv3_comment()

if ( ! function_exists( 'dv3_posted_on' ) ) :
/**
 * Pinta código HTML con el autor y fecha del post actual.
 */
function dv3_posted_on() {
    printf('<span class="by-author">Escrito por <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span><span class="sep"> el </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date('d F Y') ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        sprintf( esc_attr__( 'View all posts by %s', 'dv3' ), get_the_author() ),
        esc_html( get_the_author() )
    );
}
endif;

/**
 * Muestra una lista de los posts más comentados.
 *
 * @param unknown_type $no_posts
 * @param unknown_type $before
 * @param unknown_type $after
 * @param unknown_type $show_pass_post
 * @param unknown_type $duration
 */
function dv3_most_commented_posts($no_posts = 10, $before = '<li><i class="fa-li fa fa-comments"></i>', $after = '</li>', $show_pass_post = false, $duration='') {
    global $wpdb;
    $request = "SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS 'comment_count' FROM $wpdb->posts, $wpdb->comments";
    $request .= " WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish'";
    if(!$show_pass_post) $request .= " AND post_password =''";
    if($duration !="") {
        $request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) <post_date ";
    }
    $request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC, post_date DESC LIMIT $no_posts";
    $posts = $wpdb->get_results($request);
    $output = '';
    if ($posts) {
        foreach ($posts as $post) {
            $post_title = stripslashes($post->post_title);
            $comment_count = $post->comment_count;
            $permalink = get_permalink($post->ID);
            $output .= $before . '<a href="' . $permalink . '" title="' . $post_title.'">' . $post_title . '</a> (' . $comment_count.')' . $after;
        }
    } else {
        $output .= $before . "No hay nada" . $after;
    }
    echo $output;
}

/**
* @link wp_includes/general_template.php
*/
function dv3_get_archives($args = '') {
    global $wpdb, $wp_locale;

    $defaults = array(
        'type' => 'monthly', 'limit' => '',
        'format' => 'html', 'before' => '<i class="fa-li fa fa-calendar-o"></i>',
        'after' => '', 'show_post_count' => false,
        'echo' => 1
    );

    $r = wp_parse_args( $args, $defaults );
    extract( $r, EXTR_SKIP );

    if ( '' == $type )
    $type = 'monthly';

    if ( '' != $limit ) {
        $limit = absint($limit);
        $limit = ' LIMIT '.$limit;
    }

    // this is what will separate dates on weekly archive links
    $archive_week_separator = '&#8211;';

    // over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
    $archive_date_format_over_ride = 0;

    // options for daily archive (only if you over-ride the general date format)
    $archive_day_date_format = 'Y/m/d';

    // options for weekly archive (only if you over-ride the general date format)
    $archive_week_start_date_format = 'Y/m/d';
    $archive_week_end_date_format	= 'Y/m/d';

    if ( !$archive_date_format_over_ride ) {
        $archive_day_date_format = get_option('date_format');
        $archive_week_start_date_format = get_option('date_format');
        $archive_week_end_date_format = get_option('date_format');
    }

    //filters
    $where = apply_filters('getarchives_where', "WHERE post_type = 'post' AND post_status = 'publish'", $r );
    $join = apply_filters('getarchives_join', "", $r);

    $output = '';

    if ( 'monthly' == $type ) {
        $query = "SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where AND YEAR(post_date) = '" . date('Y') . "' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_add( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        if ( $arcresults ) {
            $afterafter = $after;
            foreach ( (array) $arcresults as $arcresult ) {
                $url = get_month_link( $arcresult->year, $arcresult->month );
                $text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($arcresult->month), $arcresult->year);
                if ( $show_post_count )
                $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
                $output .= get_archives_link($url, $text, $format, $before, $after);
            }
        }
    } elseif ('yearly' == $type) {
        $query = "SELECT DISTINCT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where AND YEAR(post_date) <> '" . date('Y') . "' GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_add( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        if ($arcresults) {
            $afterafter = $after;
            foreach ( (array) $arcresults as $arcresult) {
                $url = get_year_link($arcresult->year);
                $text = sprintf('%d', $arcresult->year);
                if ($show_post_count)
                $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
                $output .= get_archives_link($url, $text, $format, $before, $after);
            }
        }
    } elseif ('curyearly' == $type) {
        $query = "SELECT DISTINCT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where AND YEAR(post_date) = '" . date('Y') . "' GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_add( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        if ($arcresults) {
            $afterafter = $after;
            foreach ( (array) $arcresults as $arcresult) {
                $url = get_year_link($arcresult->year);
                $text = sprintf('%d', $arcresult->year);
                if ($show_post_count)
                $after = '&nbsp;('.$arcresult->posts.')' . $afterafter;
                $output .= get_archives_link($url, $text, $format, $before, $after);
            }
        }
    } elseif ( 'daily' == $type ) {
        $query = "SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date DESC $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_add( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        if ( $arcresults ) {
            $afterafter = $after;
            foreach ( (array) $arcresults as $arcresult ) {
                $url	= get_day_link($arcresult->year, $arcresult->month, $arcresult->dayofmonth);
                $date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $arcresult->year, $arcresult->month, $arcresult->dayofmonth);
                $text = mysql2date($archive_day_date_format, $date);
                if ($show_post_count)
                $after = '&nbsp;('.$arcresult->posts.')'.$afterafter;
                $output .= get_archives_link($url, $text, $format, $before, $after);
            }
        }
    } elseif ( 'weekly' == $type ) {
        $start_of_week = get_option('start_of_week');
        $query = "SELECT DISTINCT WEEK(post_date, $start_of_week) AS `week`, YEAR(post_date) AS yr, DATE_FORMAT(post_date, '%Y-%m-%d') AS yyyymmdd, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY WEEK(post_date, $start_of_week), YEAR(post_date) ORDER BY post_date DESC $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_add( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        $arc_w_last = '';
        $afterafter = $after;
        if ( $arcresults ) {
            foreach ( (array) $arcresults as $arcresult ) {
                if ( $arcresult->week != $arc_w_last ) {
                    $arc_year = $arcresult->yr;
                    $arc_w_last = $arcresult->week;
                    $arc_week = get_weekstartend($arcresult->yyyymmdd, get_option('start_of_week'));
                    $arc_week_start = date_i18n($archive_week_start_date_format, $arc_week['start']);
                    $arc_week_end = date_i18n($archive_week_end_date_format, $arc_week['end']);
                    $url  = sprintf('%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d', get_option('home'), '', '?', '=', $arc_year, '&amp;', '=', $arcresult->week);
                    $text = $arc_week_start . $archive_week_separator . $arc_week_end;
                    if ($show_post_count)
                    $after = '&nbsp;('.$arcresult->posts.')'.$afterafter;
                    $output .= get_archives_link($url, $text, $format, $before, $after);
                }
            }
        }
    } elseif ( ( 'postbypost' == $type ) || ('alpha' == $type) ) {
        $orderby = ('alpha' == $type) ? "post_title ASC " : "post_date DESC ";
        $query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
        $key = md5($query);
        $cache = wp_cache_get( 'wp_get_archives' , 'general');
        if ( !isset( $cache[ $key ] ) ) {
            $arcresults = $wpdb->get_results($query);
            $cache[ $key ] = $arcresults;
            wp_cache_add( 'wp_get_archives', $cache, 'general' );
        } else {
            $arcresults = $cache[ $key ];
        }
        if ( $arcresults ) {
            foreach ( (array) $arcresults as $arcresult ) {
                if ( $arcresult->post_date != '0000-00-00 00:00:00' ) {
                    $url  = get_permalink($arcresult);
                    $arc_title = $arcresult->post_title;
                    if ( $arc_title )
                    $text = strip_tags(apply_filters('the_title', $arc_title));
                    else
                    $text = $arcresult->ID;
                    $output .= get_archives_link($url, $text, $format, $before, $after);
                }
            }
        }
    }
    if ( $echo )
    echo $output;
    else
    return $output;
}

/**
 * La hemeroteca.
 */
function dv3_get_archive() {
    echo '<li><i class="fa-li fa fa-calendar-o"></i>';
    dv3_get_archives('type=curyearly&show_post_count=true&after=&before=&format=custom');
    echo '<ul class="fa-ul">';
    dv3_get_archives('type=monthly&show_post_count=true');
    echo '</ul></li>';
    dv3_get_archives('type=yearly&show_post_count=true');
}

/**
 * Nube de tags.
 */
function dv3_tag_cloud() {
    echo '<li><i class="fa-li fa fa-tag"></i>';
    $tags = wp_tag_cloud('smallest=1&largest=1&unit=em&separator=</li><li><i class="fa-li fa fa-tag"></i>&orderby=count&order=DESC&number=5&echo=0');
    $tags = str_replace('topics', 'posts', $tags);
    $tags = str_replace('topic', 'post', $tags);
    echo $tags;
    echo '</li>';
}

/**
 * Blogroll.
 */
function dv3_blogroll() {
    wp_list_bookmarks('categorize=0&category=154&title_li=&before=<li><i class="fa-li fa fa-link"></i>');
}

/**
 * Breadcrumbs.
 */
function dv3_breadcrumbs() {
    echo '<li>';
    if (is_home()) {
        echo 'Inicio';
    } else {
        echo "<a href='".site_url()."' title='Inicio'>Inicio</a>";
    }
    echo '</li> ';

    if (is_single()) {
        the_title('<li>', '</li> ');
    }

    if (is_category()) {
        echo '<li>';
        echo "<a href='".site_url()."/categories/' title='Temas'>Temas</a>";
        echo '</li> ';
        echo '<li>';
        single_cat_title();
        echo '</li>';
    }

    if (is_tag()) {
        echo '<li>';
        echo "<a href='".site_url()."/tags/' title='Etiquetas'>Etiquetas</a>";
        echo '</li> ';
        echo '<li>';
        single_tag_title();
        echo '</li>';
    }

    if (is_author()) {
        echo '<li>';
        echo wp_title('');
        echo '</li>';
    }

    if (is_date()) {
        echo '<li>';
        if (!is_year()) {
            echo "<a href='".site_url()."/".get_the_date('Y')."/' title='".get_the_date('Y')."'>";
        }
        echo get_the_date('Y');
        if (!is_year()) {
            echo "</a>";
        }
        echo '</li> ';

        if (!is_year()) {
            echo '<li>';
            if (!is_month()) {
                echo "<a href='".site_url()."/".get_the_date('Y')."/".get_the_date('m')."/' title='".get_the_date('F')."'>";
            }
            echo get_the_date('F');
            if (!is_month()) {
                echo "</a>";
            }
            echo '</li> ';
        }

        if (is_day()) {
            echo '<li>';
            echo get_the_date('d');
            echo '</li>';
        }
    }

    if (is_page('categories')) {
        echo '<li>';
        echo "Temas";
        echo '</li> ';
    }

    if (is_page('tags')) {
        echo '<li>';
        echo "Etiquetas";
        echo '</li> ';
    }

    if (is_404()) {
        echo '<li>';
        echo "Error";
        echo '</li> ';
    }
}

/**
 * Formulario de comentarios.
 */
function dv3_comment_form() {
    global $current_user;
    get_currentuserinfo();

    $defaults = array(
            'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comentario', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
            'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'Debes estar <a href="%s">logado</a> para dejar un comentario.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
            'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logado como <a href="%1$s">%2$s</a>. <a href="%3$s" title="Salir de esta cuenta">¿Salir?</a>' ), admin_url( 'profile.php' ), $current_user->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
            'comment_notes_before' => '<p class="comment-notes">' . __( 'Tu dirección de email no será publicada.' ) . ( $req ? $required_text : '' ) . '</p>',
            'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'Puedes usar estas etiquetas y atributos <abbr title="HyperText Markup Language">HTML</abbr>: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
            'id_form'              => 'commentform',
            'id_submit'            => 'submit',
            'title_reply'          => __( 'Pon un comentario' ),
            'title_reply_to'       => __( 'Responde a %s' ),
            'cancel_reply_link'    => __( 'Cancela la respuesta' ),
            'label_submit'         => __( '¡Comenta!' ),
    );

    comment_form($defaults);
}

/**
 * El título.
 */
function dv3_title($append = '') {
    $title = '';

    if (is_single()) {
        the_title('', '');
    }

    if (is_category()) {
        $title .= single_cat_title();
    }

    if (is_tag()) {
        $title .= single_tag_title();
    }

    if (is_author()) {
        $title .= wp_title('');
    }

    if (is_date()) {
        if (is_year()) {
            $title .= get_the_date('Y');
        } else if (is_month()) {
            $title .= get_the_date('F Y');
        } else if (is_day()) {
            $title .= get_the_date('d F Y');
        }
    }

    if (is_page('categories')) {
        $title .= 'Todos los temas';
    }

    if (is_page('tags')) {
        $title .= 'Todas las etiquetas';
    }

    if (is_404()) {
        $title .= 'Error';
    }

    if (is_home()) {
        $title .= get_bloginfo('name');
    }

    $title .= $append;
    return $title;
}

function dv3_list_categories() {
    $categories = wp_list_categories('echo=0&title_li=&show_count=1');
    $categories = str_replace('<a href', '<i class="fa-li fa fa-folder-open"></i><a href', $categories);
    echo $categories;
}
