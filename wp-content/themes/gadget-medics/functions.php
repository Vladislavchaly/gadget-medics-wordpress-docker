<?php


//custom load more
function blog_scripts() {
    // Register the script
    wp_register_script( 'custom-script', get_stylesheet_directory_uri(). '/js/custom-load-more.js', array('jquery'), false, true );

    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'load_more_posts' ),
    );
    wp_localize_script( 'custom-script', 'blog', $script_data_array );

    // Enqueued script with localized data.
    wp_enqueue_script( 'custom-script' );
    //slick
    wp_enqueue_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css');
    wp_enqueue_style( 'slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css' );
    wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js', array(), '', true );
//    wp_enqueue_script( 'skick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'blog_scripts' );
add_theme_support( 'title-tag' );

