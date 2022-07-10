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

add_action('wp_ajax_load_marketplaces_by_ajax', 'load_marketplaces_by_ajax_callback');
add_action('wp_ajax_nopriv_load_marketplaces_by_ajax', 'load_marketplaces_by_ajax_callback');


function load_marketplaces_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'post',
        'category_name' => 'Smartphones Marketplace',
        'posts_per_page' => '3',
        'paged' => $paged,
    );
    $blog_posts = new WP_Query( $args );
    ?>

    <?php if ($blog_posts->have_posts()) : ?>
        <?php while ($blog_posts->have_posts()): $blog_posts->the_post(); ?>
            <?php $post_id = get_the_ID();
            $categories = get_the_category($post_id);
            $price = get_field('price');

            $memory = get_field('memory');
            $color = get_field('color');
            $condition = get_field('condition');
            $carrier = get_field('carrier');
            $type = get_field('type');
            $series = get_field('series');
            $screen = get_field('screen');
            ?>
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id )); ?>
            <div class="products-block__item">
                <div  class="products-block__link">
                                        <span class="products-block__img" style="position: relative">
                                            <p class="price-cst">$<?php echo $price?></p>
                                            <img src="<?php echo $image[0] ?>" alt="">
                                        </span>
                    <div class="products-block__txt">
                                        <span class="product-cat-name">
                                            <?php echo  $categories[0]->name ?>
                                        </span>
                        <span class="h4"><?php the_title();?></span>
                        <?php if($memory) {?>
                            <div class="tes">
                                <ul class="colors-list">
                                    <li><?php echo '   '.$memory ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Memory</p>
                            </div>
                        <?php }?>
                        <?php if($color) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$color ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Color</p>
                            </div>
                        <?php }?>
                        <?php if($condition) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$condition ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Condition</p>
                            </div>
                        <?php }?>
                        <?php if($series) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$series ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Series</p>
                            </div>
                        <?php }?>
                        <?php if($type) {?>
                            <div class="tes">
                                <ul class="colors-list">
                                    <li><?php echo '   '.$type ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Type</p>
                            </div>
                        <?php }?>
                        <?php if($screen) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$screen ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Screen</p>
                            </div>
                        <?php }?>
                        <a href="#" class="btn btn-outline btn-outline-primary cst-modal" style="margin-top: 20px">
                            <b>Reserve for in-store pickup</b>
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif;

    wp_die();
}


