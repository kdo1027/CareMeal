<?php

$paged = !empty($_POST['paged']) ? (int)$_POST['paged'] : (!empty($_GET['paged']) ? (int)$_GET['paged'] : ( get_query_var("paged") ? get_query_var("paged") : 1 ) );
$posts_per_page = (int)get_option('posts_per_page');
$search_terms = get_query_var( 'search_terms' );

global $wp_query;
$total_post_count = $wp_query->found_posts;
$max_paged = ceil( $total_post_count / $posts_per_page );




$content = get_the_content();
$content = apply_filters( 'the_content', $content );
$content = preg_replace( '/\[.*?(\"title\":\"(.*?)\").*?\]/', '$2', $content );
$content = preg_replace( '/\[.*?(|title=\"(.*?)\".*?)\]/', '$2', $content );
$content = strip_tags( $content );
$content = preg_replace( '|\s+|', ' ', $content );
$title = get_the_title();

$cont = '';
$bFound = false;
$contlen = strlen( $content );

foreach ($search_terms as $term) {
    $pos = 0;
    $term_len = strlen($term);
    do {
        if ( $contlen <= $pos ) {
            break;
        }
        $pos = stripos( $content, $term, $pos );
        if ( $pos ) {
            $start = ($pos > 50) ? $pos - 50 : 0;
            $temp = substr( $content, $start, $term_len + 100 );
            $cont .= ! empty( $temp ) ? $temp . ' ... ' : '';
            $pos += $term_len + 50;
        }
    } while ($pos);
}

if( strlen($cont) > 0 ){
    $bFound = true;
} else {
    $cont = mb_substr( $content, 0, $contlen < 100 ? $contlen : 100 );
    if ( $contlen > 100 ){
        $cont .= '...';
    }
    $bFound = true;
}

$pattern = "#\[[^\]]+\]#";
$replace = "";
$cont = preg_replace($pattern, $replace, $cont);
$cont = preg_replace('/('.implode('|', $search_terms) .')/iu', '<mark>\0</mark>', $cont);
$title = get_the_title();
$title = preg_replace( '/('.implode( '|', $search_terms ) .')/iu', '<mark>\0</mark>', $title );
?>

<div <?php post_class('organium_standard_blog_item' . ( is_sticky() ? ' organium_sticky_post' : '' )); ?>>
    <div class="organium_standard_blog_item_wrapper">
                <div class="organium_content_wrapper">
                    <?php
                        if ( !empty(get_the_author()) || !empty(get_the_date()) ) {
                            echo '<div class="organium_post_meta">';
                                if ( !empty(get_the_date()) ) {
                                    echo '<div class="organium_post_meta_item meta_item meta_item_date">';
                                        echo '<a href="' . get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')) . '">' . get_the_date() . "</a>";
                                    echo '</div>';
                                }
                                if ( !empty(get_the_author()) ) {
                                    echo '<div class="organium_post_meta_item meta_item meta_item_author">';
                                        echo esc_html__('By ', 'organium') . get_the_author_posts_link();
                                    echo '</div>';
                                }
                            echo '</div>';
                        }
                    ?>
                    <h3 class="organium_post_title">
                        <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo sprintf('%s', $title); ?></a>
                    </h3>
                    <?php if ( !empty($cont) ) { ?>
                        <p class="organium_post_excerpt"><?php echo wp_kses($cont, array(
                            'mark'  => array(),
                            'p'     => array()
                        )); ?></p>
                    <?php } ?>
                    <?php
                        if ( !empty(get_the_tag_list()) ) {
                            echo '<div class="organium_post_meta">';
                                echo get_the_tag_list('<div class="organium_post_meta_item meta_item meta_item_tags">', ', ', '</div>');
                            echo '</div>';
                        }
                    ?>
                </div>
    </div>
</div>
