<?php
 
// Register Random_Posts_Specify_With_Thumbnail
add_action( 'widgets_init', 'register_random_posts_specify_with_thumbnail' );
     
function register_random_posts_specify_with_thumbnail() { 
    register_widget( 'Random_Posts_Specify_With_Thumbnail' ); 
}

/**
 * Adds Random_Posts_Specify_With_Thumbnail widget.
 */
class Random_Posts_Specify_With_Thumbnail extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'random_posts_specify_with_thumbnail_widget', // Base ID
            'Losowe posty z grafiką widgetu', // Name
            array( 'description' => __( 'Specify how many random posts you want to display. Also add a thumbnail to the widget.', 'text_domain' ), ) // Args
        );
    }
 
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $post_count = $instance['post_count'];
        $show_widget_thumbnail = $instance['show_widget_thumbnail'] ? 'true' : 'false';
        $widget_thumbnail_url = $instance['widget_thumbnail_url'];
        $widget_post_order = $instance['widget_post_order'];
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }

        if ( $show_widget_thumbnail === 'true' ) {
            echo '<div><img src="' . $widget_thumbnail_url . '"></div>';
        }

        echo '<p>Displaying ' . $post_count . ' random posts:</p>';

        if ( $widget_post_order == 'rand' ) {
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $post_count,
                'orderby' => 'rand'
            );
        } else {
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $post_count,
                'order' => $widget_post_order
            );
        }
        
        
        $query = query_posts( $args );

        $output_html = '<div>';

        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                $permalink_tmp = get_the_permalink();
                $title_tmp = get_the_title();
                $output_html = $output_html . '<p><a href="' . $permalink_tmp . '">' . $title_tmp . '</a></p>';
            }
        } else {
            $output_html = $output_html . '<span>THERE\'RE NO POSTS YET</span>';
        }

        $output_html = $output_html . '</div>';

        echo $output_html;

        echo $after_widget;
    }
 
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = __( 'New title', 'text_domain' );
        }
        
        if ( isset( $instance[ 'post_count' ] ) ) {
            $post_count = $instance[ 'post_count' ];
        } else {
            $post_count = 1;
        }

        $show_widget_thumbnail = $instance[ 'show_widget_thumbnail' ];

        if ( isset( $instance[ 'widget_thumbnail_url' ] ) ) {
            $widget_thumbnail_url = $instance[ 'widget_thumbnail_url' ];
        } else {
            $widget_thumbnail_url = '';
        }

        if ( isset( $instance[ 'widget_post_order' ] ) ) {
            $widget_post_order = $instance[ 'widget_post_order' ];
        } else {
            $widget_post_order = 'rand';
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <p><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
            
            <label for="<?php echo $this->get_field_name( 'post_count' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <p><input class="widefat" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="number" value="<?php echo esc_attr( $post_count ); ?>" /></p>

            <label for="<?php echo $this->get_field_name( 'show_widget_thumbnail' ); ?>"><?php _e( "Show widget's thumbnail? "); ?></label>
            <p>
                <input 
                    class="widefat" 
                    id="<?php echo $this->get_field_id( 'show_widget_thumbnail' ); ?>" 
                    name="<?php echo $this->get_field_name( 'show_widget_thumbnail' ); ?>" 
                    type="checkbox" 
                    <?php checked( $instance[ 'show_widget_thumbnail' ], 'on' ); ?>
                />
            </p>

            <label for="<?php echo $this->get_field_name( 'widget_thumbnail_url' ); ?>"><?php _e( "Enter widget's thumbnail URL:"); ?></label>
            <p><input class="widefat" id="<?php echo $this->get_field_id( 'widget_thumbnail_url' ); ?>" name="<?php echo $this->get_field_name( 'widget_thumbnail_url' ); ?>" type="url" placeholder="https://example.com" value="<?php echo esc_attr( $widget_thumbnail_url ); ?>" <?php echo(isset($show_widget_thumbnail) ? 'checked' : null); ?>/></p>

            <label for="<?php echo $this->get_field_name( 'widget_post_order' ); ?>"><?php _e( "Choose posts display order"); ?></label>
            <p>
                <select id="<?php echo $this->get_field_id( 'widget_post_order' ); ?>" name="<?php echo $this->get_field_name( 'widget_post_order' ); ?>" value="<?php echo esc_attr( $widget_post_order ); ?>">
                    <option value="asc" <?php echo($widget_post_order == 'asc' ? 'selected' : null) ?>>Ascending</option>
                    <option value="desc" <?php echo($widget_post_order == 'desc' ? 'selected' : null) ?>>Descending</option>
                    <option value="rand" <?php echo($widget_post_order == 'rand' ? 'selected' : null) ?>>Random</option>
                </select>
            </p>

            <p>
                Created with ♥ by <a href="https://adrszl.github.io/" traget="_blank">Adrian Szlegel</a>
            </p>
        </p>
    <?php
    }
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['post_count'] = ( !empty( $new_instance['post_count'] ) ) ? $new_instance['post_count'] : 1;
        $instance['show_widget_thumbnail'] = $new_instance['show_widget_thumbnail'];
        $instance['widget_thumbnail_url'] = ( !empty( $new_instance['widget_thumbnail_url'] ) ) ? strip_tags( $new_instance['widget_thumbnail_url'] ) : '';
        $instance['widget_post_order'] = $new_instance['widget_post_order'];

        return $instance;
    }
 
} // class Foo_Widget
 
?>