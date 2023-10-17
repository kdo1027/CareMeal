<?php
/*
 * Created by Artureanec
*/

if (!class_exists('organium_socials_widget'))
{
    class organium_socials_widget extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct(
                'organium_socials_widget',
                'Socials Widget (Organium Theme)',
                array('description' => esc_html__('Display Your Logo and Social Icons from Customizer', 'organium_plugin'))
            );
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = esc_attr($new_instance['title']);
            $instance['logo'] = esc_attr($new_instance['logo']);
            $instance['social'] = esc_attr($new_instance['social']);
            $instance['logo_type'] = esc_attr($new_instance['logo_type']);
            $instance['logo_width'] = esc_attr($new_instance['logo_width']);
            $instance['logo_height'] = esc_attr($new_instance['logo_height']);

            return $instance;
        }

        public function form($instance)
        {
            $default_values = array(
                'title' => esc_html__('Socials', 'organium_plugin'),
                'logo' => 'enabled',
                'social' => 'enabled',
                'logo_type' => 'transparent',
                'logo_width' => 175,
                'logo_height' => 64
            );

            $instance = wp_parse_args((array)$instance, $default_values);
            ?>
            <p class="organium_widget">
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title', 'organium_plugin'); ?>:
                </label>
                <input class="widefat"
                       type="text"
                       id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                       value="<?php echo esc_html($instance['title']); ?>"
                />

                <label for="<?php echo esc_attr($this->get_field_id('logo')); ?>">
                    <?php echo esc_html__('Logo Image', 'organium_plugin'); ?>:
                </label>
                <select name="<?php echo esc_attr($this->get_field_name('logo')); ?>"
                        id="<?php echo esc_attr($this->get_field_id('logo')); ?>">
                    <option value="enabled" <?php selected($instance['logo'], 'enabled'); ?>><?php echo esc_html__('Enabled', 'organium_plugin'); ?></option>
                    <option value="disabled" <?php selected($instance['logo'], 'disabled'); ?>><?php echo esc_html__('Disabled', 'organium_plugin'); ?></option>
                </select>

                <label for="<?php echo esc_attr($this->get_field_id('social')); ?>">
                    <?php echo esc_html__('Social Buttons', 'organium_plugin'); ?>:
                </label>
                <select name="<?php echo esc_attr($this->get_field_name('social')); ?>"
                        id="<?php echo esc_attr($this->get_field_id('social')); ?>">
                    <option value="enabled" <?php selected($instance['social'], 'enabled'); ?>><?php echo esc_html__('Enabled', 'organium_plugin'); ?></option>
                    <option value="disabled" <?php selected($instance['social'], 'disabled'); ?>><?php echo esc_html__('Disabled', 'organium_plugin'); ?></option>
                </select>

                <label for="<?php echo esc_attr($this->get_field_id('logo_type')); ?>">
                    <?php echo esc_html__('Type of Logo Image', 'organium_plugin'); ?>:
                </label>
                <select name="<?php echo esc_attr($this->get_field_name('logo_type')); ?>"
                        id="<?php echo esc_attr($this->get_field_id('logo_type')); ?>">
                    <option value="default" <?php selected($instance['logo_type'], 'default'); ?>><?php echo esc_html__('Default Logo Image', 'organium_plugin'); ?></option>
                    <option value="transparent" <?php selected($instance['logo_type'], 'transparent'); ?>><?php echo esc_html__('Transparent Header Logo Image', 'organium_plugin'); ?></option>
                </select>

                <label for="<?php echo esc_attr($this->get_field_id('logo_width')); ?>">
                    <?php echo esc_html__('Enter Logo Image Width', 'organium_plugin'); ?>:
                </label>
                <input class="widefat"
                       type="text"
                       id="<?php echo esc_attr($this->get_field_id('logo_width')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('logo_width')); ?>"
                       value="<?php echo esc_html($instance['logo_width']); ?>"
                />

                <label for="<?php echo esc_attr($this->get_field_id('logo_height')); ?>">
                    <?php echo esc_html__('Enter Logo Image Height', 'organium_plugin'); ?>:
                </label>
                <input class="widefat"
                       type="text"
                       id="<?php echo esc_attr($this->get_field_id('logo_height')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('logo_height')); ?>"
                       value="<?php echo esc_html($instance['logo_height']); ?>"
                />
            </p>
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

            if (isset($instance['logo']) && $instance['logo'] == 'enabled') {
                if ($instance['logo_type'] == 'default') {
                    $logo_image = organium_get_theme_mod('logo_image');
                } else {
                    $logo_image = organium_get_theme_mod('logo_transparent_image');
                }

                echo '
                    <div class="organium_socials_widget_logo">
                        <a href="' . esc_url(home_url('/')) . '">
                            <img src="' . esc_url($logo_image) . '" alt="Footer Logo" width="' . absint($instance['logo_width']) . '" height="' . absint($instance['logo_height']) . '" />
                        </a>
                    </div>
                ';
            }

            if (isset($instance['social']) && $instance['social'] == 'enabled') {
                echo organium_socials_output('organium-socials');
            }

            echo $after_widget;
        }
    }
}
