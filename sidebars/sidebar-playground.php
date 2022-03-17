<?php

function playground_sidebar_init() {
    register_sidebar( array(
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',        
        'name'=>__( 'Playground sidebar', 'textdomain' ), 
        'description'   => __( 'Sidebar do ćwiczeń', 'textdomain' ),
        'id'            => 'playground-sidebar',
    ) );
}

add_action( 'widgets_init', 'playground_sidebar_init' );

?>