<?php
/*
 * Created by Artureanec
*/

if (!class_exists('organium_address_widget'))
{
    class organium_address_widget extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct(
                'organium_address_widget',
                'Contacts Widget (Organium Theme)',
                array(
                    'description' => esc_html__('Contacts Widget by Organium Theme', 'organium_plugin'),
                    'mime_type'   => 'image'
                )
            );
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = esc_attr($new_instance['title']);
            $instance['logo'] = strip_tags( $new_instance['logo']);
            $instance['retina'] = esc_attr($new_instance['retina']);
            $instance['address'] = esc_attr($new_instance['address']);
            $instance['phone'] = esc_attr($new_instance['phone']);
            $instance['email'] = esc_attr($new_instance['email']);
            $instance['social'] = esc_attr($new_instance['social']);
            $instance['text'] = esc_attr($new_instance['text']);

            return $instance;
        }

        public function form($instance)
        {
            $default_values = array(
                'title' => '',
                'logo' => '',
                'retina' => false,
                'address' => '',
                'phone' => '',
                'email' => '',
                'social' => 'disabled',
                'text' => ''
            );

            $instance = wp_parse_args((array)$instance, $default_values);
            $retina     = isset( $instance['retina'] ) ? (bool) $instance['retina'] : false;
            ?>

            <div class="organium_widget">
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                        <?php echo esc_html__('Title', 'organium_plugin'); ?>:
                    </label>
                    <input class="widefat"
                           type="text"
                           id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                           value="<?php echo esc_html($instance['title']); ?>"
                    />
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id( 'logo' ); ?>"><?php echo esc_html__( 'Logo:', 'organium_plugin' ); ?></label>
                </p>

                <div class="media-widget-preview media_image">
                    <?php
                    $logo_id = attachment_url_to_postid( $instance['logo'] );
                    echo '<img class="attachment-thumb ' . $this->get_field_id( 'logo' ) . '_img' . (empty($instance['logo']) ? ' hidden' : '') . '" src="' . (!empty($instance['logo']) ? esc_url(wp_get_attachment_image_url($logo_id, 'medium')) : '' ) . '" />';
                    ?>
                    <div class="attachment-media-view">
                        <button type="button" id="<?php echo $this->get_field_id( 'logo' ) ?>" class="button select-media button-add-media not-selected js_custom_upload_media<?php echo empty($instance['logo']) ? ' empty' : ' hidden'; ?>"><?php echo esc_html__('Add Image', 'organium_plugin') ?></button>
                    </div>
                    <input hidden type="text" class="widefat <?php echo $this->get_field_id( 'logo' ) ?>_url" name="<?php echo esc_attr( $this->get_field_name( 'logo' ) ); ?>" value="<?php echo !empty($instance['logo']) ? $instance['logo'] : ''; ?>" />
                </div>

                <p class="media-widget-buttons">
                    <button id="<?php echo $this->get_field_id( 'logo' ).'_remove' ?>" type="button" class="button js_custom_remove_media<?php echo (empty($instance['logo']) ? ' hidden' : ''); ?>"><?php echo esc_html__('Replace Image', 'organium_plugin') ?></button>
                </p>

                <p>
                    <label for="<?php echo $this->get_field_id( 'retina' ); ?>">
                        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'retina' ); ?>" name="<?php echo $this->get_field_name( 'retina' ); ?>"<?php checked( $retina ); ?> />
                        <?php esc_html_e( 'Logo Retina', 'organium_plugin' ); ?>
                    </label>
                </p>

                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('address')); ?>">
                        <?php echo esc_html__('Address', 'organium_plugin'); ?>:
                    </label>
                    <textarea class="widefat"
                           id="<?php echo esc_attr($this->get_field_id('address')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('address')); ?>"
                    ><?php echo esc_attr($instance['address']); ?></textarea>
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>">
                        <?php echo esc_html__('Phone Number', 'organium_plugin'); ?>:
                    </label>
                    <input class="widefat"
                           type="text"
                           id="<?php echo esc_attr($this->get_field_id('phone')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('phone')); ?>"
                           value="<?php echo esc_html($instance['phone']); ?>"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('email')); ?>">
                        <?php echo esc_html__('Email', 'organium_plugin'); ?>:
                    </label>
                    <input class="widefat"
                           type="text"
                           id="<?php echo esc_attr($this->get_field_id('email')); ?>"
                           name="<?php echo esc_attr($this->get_field_name('email')); ?>"
                           value="<?php echo esc_html($instance['email']); ?>"
                    />
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('social')); ?>">
                        <?php echo esc_html__('Social Buttons', 'organium_plugin'); ?>:
                    </label>
                    <select name="<?php echo esc_attr($this->get_field_name('social')); ?>"
                            id="<?php echo esc_attr($this->get_field_id('social')); ?>">
                        <option value="disabled" <?php selected($instance['social'], 'disabled'); ?>><?php echo esc_html__('Disabled', 'organium_plugin'); ?></option>
                        <option value="enabled" <?php selected($instance['social'], 'enabled'); ?>><?php echo esc_html__('Enabled', 'organium_plugin'); ?></option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                        <?php echo esc_html__('Description', 'organium_plugin'); ?>:
                    </label>
                    <textarea class="widefat"
                              id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                              name="<?php echo esc_attr($this->get_field_name('text')); ?>"
                    ><?php echo esc_attr($instance['text']); ?></textarea>
                </p>
            </div>
            <?php
        }

        public function widget($args, $instance)
        {
            extract($args);

            echo $before_widget;
            if ($instance['title']) {
                echo $before_title;
                echo apply_filters('widget_title', $instance['title']);
                echo $after_title;
            }

            echo '
                <div class="organium_contacts_widget_wrapper">';
                    if ( !empty($instance['logo']) ) {
                        $demo_url = 'https://organium.artureanec.com';
                        $current_url = get_home_url();
                        if ( strpos($instance['logo'], $demo_url) === false ) {
                            $url = $instance['logo'];
                        } else {
                            $url = str_replace($demo_url, $current_url, $instance['logo']);
                        }
                        $logo_meta = wp_get_attachment_metadata( attachment_url_to_postid($url) );
                        if ( $instance['retina'] == true ) {
                            $logo_width = (isset($logo_meta['width']) ? floor($logo_meta['width'] / 2 ) : 0);
                            $logo_height = (isset($logo_meta['height']) ? floor( $logo_meta['height'] / 2 ) : 0);
                        } else {
                            $logo_width = (isset($logo_meta['width']) ? $logo_meta['width'] : 0);
                            $logo_height = (isset($logo_meta['height']) ? $logo_meta['height'] : 0);
                        }
                        echo '<div class="organium_contacts_widget_logo' . ($instance['retina'] == true ? ' organium_retina_logo' : '') . '">';
                            echo '<a href="' . esc_url(home_url('/')) . '">';
                                echo '<img width="' . esc_attr($logo_width) . '" height="' . esc_attr($logo_height) . '" src="'.esc_url($url).'" alt="' . esc_attr__('Logo', 'organium_plugin') . '" />';
                            echo '</a>';
                        echo '</div>';
                    }

                    if ($instance['email'] !== '') {
                        echo '
                            <div class="organium_contacts_widget_email">
                                <strong>' . esc_html__('Email: ', 'organium_plugin') . '</strong>
                                <a href="mailto:' . esc_attr($instance['email']) . '">
                                    ' . esc_html($instance['email']) . '
                                </a>
                            </div>
                        ';
                    }

                    if ($instance['phone'] !== '') {
                        $phone = str_replace(array('(', ')', ' ', '-'), '', $instance['phone']);
                        echo '
                            <div class="organium_contacts_widget_phone">
                                <strong>' . esc_html__('Phone: ', 'organium_plugin') . '</strong>
                                <a href="tel:' . esc_attr($phone) . '">
                                    ' . esc_html($instance['phone']) . '
                                </a>
                            </div>
                        ';
                    }

                    if ($instance['address'] !== '') {
                        echo '<div class="organium_contacts_widget_address">';
                            echo '<strong>' . esc_html__('Address: ', 'organium_plugin') . '</strong>';
                            echo esc_html($instance['address']);
                        echo '</div>';
                    }

                    if (isset($instance['social']) && $instance['social'] == 'enabled') {
                        echo organium_socials_output('organium-socials');
                    }

                    if ($instance['text'] !== '') {
                        echo '
                            <div class="organium_contacts_widget_description">
                                <p>
                                    ' . esc_html($instance['text']) . '
                                </p>
                            </div>
                        ';
                    }
                    echo '
                </div>
            ';

            echo $after_widget;
        }
    }
}
