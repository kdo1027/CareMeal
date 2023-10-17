<?php
/*
 * Created by Artureanec
*/

if (!class_exists('organium_recipes_categories_widget'))
{
    class organium_recipes_categories_widget extends WP_Widget
    {
        public function __construct()
        {
            parent::__construct(
                'organium_recipes_categories_widget',
                'Recipes Categories (Organium Theme)',
                array('description' => esc_html__('Recipes Categories Widget by Organium Theme', 'organium_plugin'))
            );
        }

        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;

            $instance['title'] = sanitize_text_field($new_instance['title']);
            $instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;
            $instance['hierarchical'] = ! empty( $new_instance['hierarchical'] ) ? 1 : 0;
            $instance['dropdown']     = ! empty( $new_instance['dropdown'] ) ? 1 : 0;

            return $instance;
        }

        public function form($instance)
        {
            // Defaults.
            $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
            $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
            $dropdown     = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
            ?>
            <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

            <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'dropdown' ); ?>" name="<?php echo $this->get_field_name( 'dropdown' ); ?>"<?php checked( $dropdown ); ?> />
                <label for="<?php echo $this->get_field_id( 'dropdown' ); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>"<?php checked( $count ); ?> />
                <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show post counts' ); ?></label><br />

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'hierarchical' ); ?>" name="<?php echo $this->get_field_name( 'hierarchical' ); ?>"<?php checked( $hierarchical ); ?> />
                <label for="<?php echo $this->get_field_id( 'hierarchical' ); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
            <?php
        }

        public function widget($args, $instance)
        {
            static $first_dropdown = true;

            $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recipes Categories' );
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

            $count        = ! empty( $instance['count'] ) ? '1' : '0';
            $hierarchical = ! empty( $instance['hierarchical'] ) ? '1' : '0';
            $dropdown     = ! empty( $instance['dropdown'] ) ? '1' : '0';

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            $cat_args = array(
                'orderby'      => 'name',
                'show_count'   => $count,
                'hierarchical' => $hierarchical,
            );

            if ( $dropdown ) {
                echo sprintf( '<form action="%s" method="get">', esc_url( home_url() ) );
                    $dropdown_id    = ( $first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";
                    $first_dropdown = false;
                    echo '<label class="screen-reader-text" for="' . esc_attr( $dropdown_id ) . '">' . $title . '</label>';
                    $cat_args['show_option_none'] = __( 'Select Category' );
                    $cat_args['id']               = $dropdown_id;
                    $cat_args['taxonomy']         = 'recipes-category';
                    wp_dropdown_categories( apply_filters( 'widget_recipes_categories_dropdown_args', $cat_args, $instance ) );
                echo '</form>';

                $type_attr = current_theme_supports( 'html5', 'script' ) ? '' : ' type="text/javascript"';
                ?>

                <script<?php echo $type_attr; ?>>
                    /* <![CDATA[ */
                    (function() {
                        var dropdown = document.getElementById( "<?php echo esc_js( $dropdown_id ); ?>" );
                        function onCatChange() {
                            if ( dropdown.options[ dropdown.selectedIndex ].value > 0 ) {
                                dropdown.parentNode.submit();
                            }
                        }
                        dropdown.onchange = onCatChange;
                    })();
                    /* ]]> */
                </script>

                <?php
            } else {
                ?>
                <ul>
                    <?php
                    $cat_args['title_li'] = '';
                    $cat_args['taxonomy'] = 'recipes-category';
                    wp_list_categories( apply_filters( 'widget_recipes_categories_args', $cat_args, $instance ) );
                    ?>
                </ul>
                <?php
            }

            echo $args['after_widget'];
        }
    }
}