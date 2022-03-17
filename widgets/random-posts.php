<?php 

// Register and load the widget
function wp_load_custom_widget_random_posts() {
    register_widget( 'random_posts_widget' );
}
add_action( 'widgets_init', 'wp_load_custom_widget_random_posts' );
 
// Creating the widget 
class random_posts_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'random_posts_widget', 
        
        // Widget name will appear in UI
        __('11 Losowych postów', 'random_posts_domain'), 
        
        // Widget description
        array( 'description' => __( 'Widget displaying 11 random posts', 'random_posts_domain' ), ) 
        );
    }
 
    // Creating widget front-end
    
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        
        // This is where you run the code and display the output
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 11,
            'orderby' => 'rand'
        );
        //$query = new WP_Query( $args );
        $query = query_posts( $args );
        $output_html = '<div class="d-flex flex-column">';

        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                $permalink_tmp = get_the_permalink();
                $title_tmp = get_the_title();
                $output_html = $output_html . '<a href="' . $permalink_tmp . '">' . $title_tmp . '</a>';
            }
        } else {
            $output_html = $output_html . '<span>THERE\'RE NO POSTS YET</span>';
        }

        $output_html = $output_html . '</div>';

        echo __( $output_html, 'random_posts_domain' );
        echo $args['after_widget'];
    }
         
// Widget Backend 
public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
    }
    else {
        $title = __( 'New title', 'random_posts_domain' );
    }
    // Widget admin form
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
}
     
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    
    return $instance;
}
} // Class wpb_widget ends here

?>