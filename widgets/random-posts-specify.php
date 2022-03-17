<?php
 
// Register Foo_Widget widget
add_action( 'widgets_init', 'register_random_posts_specify' );
     
function register_random_posts_specify() { 
    register_widget( 'Random_Posts_Specify' ); 
}

/**
 * Adds Foo_Widget widget.
 */
class Random_Posts_Specify extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'random_posts_specify_widget', // Base ID
            'Losowe posty', // Name
            array( 'description' => __( 'Specify how many random posts you want to display', 'text_domain' ), ) // Args
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
 
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }

        echo '<p>Displaying ' . $post_count . ' random posts:</p>';

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $post_count,
            'orderby' => 'rand'
        );
        
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
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <p><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
            <p><input class="widefat" id="<?php echo $this->get_field_id( 'post_count' ); ?>" name="<?php echo $this->get_field_name( 'post_count' ); ?>" type="number" value="<?php echo esc_attr( $post_count ); ?>" /></p>
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
 
        return $instance;
    }
 
} // class Foo_Widget
 
?>