<?php
/*
 * Created by Artureanec
*/

if (post_password_required()) {
    return;
}

if ( ! function_exists( 'organium_comment_code' ) ) {
    function organium_comment_code($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>

        <div <?php comment_class('organium_comments__item'); ?> id="comment-<?php comment_ID() ?>">
            <div class="organium_comments__item-inner">
                <?php
                    if( $args['avatar_size'] != 0 ){
                        echo '<div class="organium_comments__item-img">';
                            echo get_avatar($comment, $args['avatar_size']);
                        echo '</div>';
                    }
                ?>

                <div class="organium_comments__item-description">
                    <?php
                    if ($comment->comment_approved == '0') {
                        echo '<p>' . esc_html__('Your comment is awaiting moderation.', 'organium') . '</p>';
                    }

                    echo '
                        <div class="organium_comment_meta">
                            <div class="organium_comment_author_cont">
                                <div class="organium_comments__item-name">' . esc_html(get_comment_author()) . '</div>
                                <div class="organium_comments__item-date">' . esc_html(get_comment_date()) . '</div>
                            </div>
                            ';
                            ?>
                            <div class="organium_comment_reply_cont">
                                <?php
                                $reply_button = '
                                    <svg class="icon">
                                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 7.9L6 3v3h2c8 0 8 8 8 8s-1-4-7.8-4H6v2.9l-6-5z"></path>
                                        </svg>
                                    </svg>
                                ' . esc_html__('reply', 'organium');

                                comment_reply_link(
                                    array_merge(
                                        $args, array(
                                            'before' => '',
                                            'after' => '',
                                            'depth' => $depth,
                                            'reply_text' => $reply_button,
                                            'max_depth' => $args['max_depth']
                                        )
                                    )
                                );
                                edit_comment_link('<i class="fa fa-pencil"></i>'.esc_html__('edit', 'organium'));
                                ?>
                            </div>
                            <?php
                            echo '
                        </div>
                    ';
                    ?>
                    <div class="organium_comments__item-text">
                        <?php comment_text(); ?>
                    </div>
                </div>
            </div>
        <?php
    }
}

if ( comments_open() || pings_open() || have_comments() ) {
    echo '<div class="organium_comments_wrapper">';

        if ( have_comments() ) {
            $comments_number = number_format_i18n( get_comments_number() );

            echo '<h4 class="organium_blog-post__title">';
                echo ( ($comments_number == '1') ? esc_html__( 'Comment', 'organium') : esc_html__('Comments', 'organium') ) . " <span class='comment_counter'>(" . esc_html($comments_number) . ")</span>";
            echo '</h4>';

            echo '<div class="organium_comments">';
                wp_list_comments(array(
                    'style' => 'div',
                    'avatar_size' => 106,
                    'type' => 'all',
                    'callback' => 'organium_comment_code'
                ));
            echo '</div>';

            the_comments_navigation();
        }

        if ( comments_open() || pings_open() ) {
            $organium_comments_field_req = get_option('require_name_email');
            comment_form(array(
                'title_reply_before' => '<h4 class="organium_blog-post__title">',
                'title_reply' => esc_html__('Post a Comment', 'organium'),
                'title_reply_after' => '</h4>',
                'fields' => array(
                    'author' => '<input class="form__field" placeholder="' . esc_attr__('Your Full Name', 'organium') . '" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" />',
                    'email' => '<input class="form__field" placeholder="' . esc_attr__('Your Email', 'organium') . '" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" />',
                    'website' => '<input class="form__field" placeholder="' . esc_attr__('Your Website', 'organium') . '" name="website" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />',
                ),
                'comment_field' => '<textarea name="comment" cols="45" rows="5" placeholder="' . esc_attr__('Comment', 'organium') . '" id="comment-message" class="form__field form__message"></textarea>',
                'label_submit' => esc_html__('Send Comment', 'organium'),
                'logged_in_as' => '<span class="logged-in-as">' . esc_html__('Logged in as ', 'organium') . '<a href="' . esc_url(admin_url('profile.php')) . '">' . esc_html(wp_get_current_user()->display_name) . '</a>. ' . '<a href="' . wp_logout_url(apply_filters('the_permalink', get_permalink())) . '">' . esc_html__('Log out?', 'organium') . '</a>' . '</span>',
            ));
        } elseif ( is_single() ) {
            echo '<p class="comments-closed">' . esc_html__( 'Comments are closed.', 'organium' ) . '</p>';
        }
    echo '</div>';
} elseif ( is_single() ) {
    echo '<div class="organium_comments_wrapper">';
        echo '<p class="comments-closed">' . esc_html__( 'Comments are closed.', 'organium' ) . '</p>';
    echo '</div>';
}