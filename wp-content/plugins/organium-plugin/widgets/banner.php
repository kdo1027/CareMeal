<?php
/*
 * Created by Artureanec
*/

if (!class_exists('organium_banner_widget'))
{
    class organium_banner_widget extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct(
                'organium_banner_widget',
                'Banner (Organium Theme)',
                array(
                    'description' => esc_html__('Banner Widget by Organium Theme', 'organium_plugin'),
                    'mime_type'   => 'image'
                )
            );
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = sanitize_text_field($new_instance['title']);

            $instance['banner_title']   = sanitize_text_field($new_instance['banner_title']);
            $instance['banner_text']    = sanitize_text_field($new_instance['banner_text']);
            $instance['button_text']    = sanitize_text_field($new_instance['button_text']);
            $instance['button_link']    = sanitize_text_field($new_instance['button_link']);
            $instance['bg']             = strip_tags( $new_instance['bg'] );

            return $instance;
        }

        public function form($instance) {
            $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );

            $banner_title = !empty( $instance['banner_title'] ) ? $instance['banner_title'] : '';
            $banner_text = !empty( $instance['banner_text'] ) ? $instance['banner_text'] : '';
            $button_text = !empty( $instance['button_text'] ) ? $instance['button_text'] : '';
            $button_link = !empty( $instance['button_link'] ) ? $instance['button_link'] : '#';
            ?>
            <div class="media-widget-control">
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'banner_title' ); ?>"><?php _e( 'Banner Title:' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'banner_title' ); ?>" name="<?php echo $this->get_field_name( 'banner_title' ); ?>" type="text" value="<?php echo esc_attr( $banner_title ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'banner_text' ); ?>"><?php _e( 'Banner Text:' ); ?></label>
                    <textarea rows="3" class="widefat textarea widget_textarea_control" name="<?php echo $this->get_field_name( 'banner_text' ); ?>" id="<?php echo esc_attr( $this->get_field_id('banner_text') ) ?>"><?php echo esc_html($banner_text) ?></textarea>
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text:' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo esc_attr( $button_text ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'button_link' ); ?>"><?php _e( 'Button Link:' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'button_link' ); ?>" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo esc_url( $button_link ); ?>" />
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'bg' ); ?>"><?php echo esc_html__( 'Background:', 'organium_plugin' ); ?></label>
                </p>

                <div class="media-widget-preview media_image">
                    <?php
                        $bg_id = attachment_url_to_postid( $instance['bg'] );
                        echo '<img class="attachment-thumb ' . $this->get_field_id( 'bg' ) . '_img' . (empty($instance['bg']) ? ' hidden' : '') . '" src="' . (!empty($instance['bg']) ? esc_url(wp_get_attachment_image_url($bg_id, 'medium')) : '' ) . '" />';
                    ?>
                    <div class="attachment-media-view">
                        <button type="button" id="<?php echo $this->get_field_id( 'bg' ) ?>" class="button select-media button-add-media not-selected js_custom_upload_media<?php echo empty($instance['bg']) ? ' empty' : ' hidden'; ?>"><?php echo esc_html__('Add Image', 'organium_plugin') ?></button>
                    </div>
                    <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'bg' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'bg' ) ); ?>" value="<?php echo !empty($instance['bg']) ? $instance['bg'] : ''; ?>" />
                </div>

                <p class="media-widget-buttons">
                    <button id="<?php echo $this->get_field_id( 'bg' ).'_remove' ?>" type="button" class="button js_custom_remove_media<?php echo (empty($instance['bg']) ? ' hidden' : ''); ?>"><?php echo esc_html__('Replace Image', 'organium_plugin') ?></button>
                </p>

            </div>
        <?php
        }

        public function widget($args, $instance) {
            $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $banner_title = !empty( $instance['banner_title'] ) ? $instance['banner_title'] : '';
            $banner_text = !empty( $instance['banner_text'] ) ? $instance['banner_text'] : '';
            $button_text = !empty( $instance['button_text'] ) ? $instance['button_text'] : '';
            $button_link = !empty( $instance['button_link'] ) ? $instance['button_link'] : '#';
            $bg = !empty( $instance['bg'] ) ? $instance['bg'] : '';

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            echo '<div class="banner-widget-wrapper">';
                if ( !empty($bg) ) {
                    echo '<img src="'.esc_url($bg).'" alt="" />';
                }
                echo '<div class="banner-content">';
                    if ( !empty($banner_title) ) {
                        echo '<h6 class="banner-title">'.esc_html($banner_title).'</h6>';
                    }
                    if ( !empty($banner_text) ) {
                        echo '<p class="banner-description">'.wp_kses($banner_text, array(
                                'strong' => true,
                                'b' => true,
                                'i' => true,
                                'mark' => true,
                                'em' => true,
                                'br' => true
                            )). '</p>';
                    }
                    if ( !empty($button_text) && !empty($button_link) ) {
                        echo '<div class="banner-button">';
                            echo '<a href="' . esc_url($button_link) . '" class="organium_button organium_button--alter">' . esc_html($button_text) . '</a>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';

            echo $args['after_widget'];
        }
    }
}