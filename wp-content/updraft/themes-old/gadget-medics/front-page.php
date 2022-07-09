<?php get_header(); $id_page=get_the_ID(); ?>

<main class="main">

    <div class="section-home">
        <div class="container">
            <div class="welcome-block">
                <div class="welcome-block__form">
                    <span class="h3"><?php the_field('welcome_form_title','options'); ?></span>
                    <?php echo do_shortcode('[fluentform id="2"]');?>
                </div>
            </div>
        </div>
    </div>

    <div class="section section-devices">
        <div class="container">
            <div class="devices-block">
                <span class="h2"><?php the_field('devices_we_repair_title',$id_page); ?></span>
                <?php
                $delay=0;
                while ( have_rows('device_menu',$id_page) ) : the_row();?>
                    <div class="devices-block__item wow animated fadeInAnimation" data-wow-delay="<?php echo $delay; ?>s">
                        <a href="<?php the_sub_field('device__menu__link'); ?>" class="devices-block__link">
                            <span class="icon icon-primary">
                                <img src="<?php the_sub_field('device_menu__icon'); ?>" alt="Gadget Medics">
                            </span>
                            <span class="devices-block__title"><?php the_sub_field('device_menu__title'); ?></span>
                            <small><?php the_sub_field('coming_soon'); ?></small>
                        </a>
                    </div>
                    <?php $delay+=0.1;?>
                <?php endwhile;?>
            </div>
            <div class="devices-block devices-block__reverse">
                <span class="h2"><?php the_field('devices_we_offer_title',$id_page); ?></span>
                <?php
                $delay=0;
                while ( have_rows('offer_device_menu',$id_page) ) : the_row();?>
                    <div class="devices-block__item wow animated fadeInAnimation" data-wow-delay="<?php echo $delay; ?>s">
                        <a href="<?php the_sub_field('offer_device__menu__link'); ?>" class="devices-block__link">
                            <span class="icon icon-primary icon-outline-primary">
                                <img src="<?php the_sub_field('offer_device_menu__icon'); ?>" alt="Gadget Medics">
                            </span>
                            <span class="devices-block__title"><?php the_sub_field('offer_device_menu__title'); ?></span>
                        </a>
                    </div>
                    <?php $delay+=0.1;?>
                <?php endwhile;?>
            </div>
        </div>
    </div>

    <div class="section section-options">
        <div class="container">
            <div class="section__title">
                <span class="h2"><?php the_field('repair_options_title_item',$id_page); ?></span>
                <p><?php the_field('repair_options_text_item',$id_page); ?></p>
            </div>
            <div class="options">
                <?php while ( have_rows('repair_options',$id_page) ) : the_row();?>
                    <div class="options-block">
                        <div class="options-block__img">
                            <img src="<?php the_sub_field('repair_options__img'); ?>" alt="">
                        </div>
                        <div class="options-block__txt">
                            <span class="h4"><?php the_sub_field('repair_options__title'); ?></span>
                            <p><?php the_sub_field('repair_options__text'); ?></p>
                            <a href="#" class="btn btn-xs btn-primary" data-fancybox data-src="#<?php the_sub_field('repair_options__modal'); ?>">Buy in store</a>
                        </div>
                    </div>
                <?php endwhile;?>
            </div>
        </div>
    </div>

    <div class="section section-primary section-schedule">
        <div class="container">
            <div class="section__title">
                <span class="h2"><?php the_field('save_title',$id_page); ?></span>
                <p><?php the_field('save_sub_title',$id_page); ?></p>
            </div>
            <div class="schedule-block">
                <?php echo do_shortcode('[fluentform id="5"]');?>
            </div>
        </div>
    </div>




<div data-token="IdS7BCUdEpHYVHzBslo0jX1psmNXP7yMPBSd2FpypFUvHoMbyV" class="romw-reviews"></div> 
<script src="https://reviewsonmywebsite.com/js/embedLoader.js?id=16985fd9e429040ba7c6" type="text/javascript"></script>
    <!--блок товаров -->
    <?php
    $all = new WP_Query(
        ['post_type' => 'post',
            'category_name' => 'Smartphones Marketplace']
    );
    $iPhones = new WP_Query(
        ['post_type' => 'post',
            'category_name' => 'iPhones']
    );
    $iPads = new WP_Query(
        ['post_type' => 'post',
            'category_name' => 'iPads']
    );
    $iWatch = new WP_Query(
        ['post_type' => 'post',
            'category_name' => 'iWatch']
    );
    $accessories = new WP_Query(
        ['post_type' => 'post',
            'category_name' => 'Accessories']
    );
    ?>
    <div class="section section-news">
        <div class="container">
            <div class="section__title">
                <span class="h2">
                    Marketplace
                </span>
            </div>
            <div class="tabs-block">
                <ul class="tabs-block__list cst-filter" style="position:relative;align-items: center">
                    <li class="tabs-block__list-item active all-product">All: <?php echo  $all->post_count?></li>
                    <li class="tabs-block__list-item f-item">iPhone: <?php echo  $iPhones->post_count?></li>
                    <li class="tabs-block__list-item f-item">iPad: <?php echo $iPads->post_count?></li>
                    <li class="tabs-block__list-item f-item">iWatch: <?php echo $iWatch->post_count?></li>
                    <li class="tabs-block__list-item f-item">Accessories: <?php echo $accessories->post_count?></li>
                    <li style="position: absolute;right: 0;"><a href="https://gadgetmedics.com/trade-in/" style=" font-weight: bold;padding:20px;font-size: 15px;color: #FFFFFF;background: #FC6464;border-radius: 27.5px 27.5px 27.5px 0px;">
                            <img src="https://gadgetmedics.com/wp-content/uploads/2019/11/arrow-right.png" style="padding-right: 10px">
                            Trade-In my device
                        </a>
                    </li>
                </ul>
                <div class="tabs-block__content">
                    <div class="tabs-block__box active">
                        <div class="products-block cst-cart-items-block">
                            <?php $the_query = new WP_Query(
                                ['post_type' => 'post',
                                    'category_name' => 'Smartphones Marketplace']
                            );
                            if ($the_query->have_posts()) : ?>
                            <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
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
                                        <style>
                                            .price-cst{
                                                background: #FC6464;
                                                border-top-right-radius: 10px;
                                                padding: 5px 14px;
                                                left: 0;
                                                position: absolute;
                                                color: white;
                                            }
                                            .tes ul{
                                                margin-right: 10px;
                                                margin-bottom: 0;
                                                margin-top: 0;
                                            }
                                            .tes ul li{
                                                font-size: 16px;
                                                line-height: 24px;
                                                color: #3A3768;
                                            }
                                            .tes p{
                                                font-size: 15px;
                                                line-height: 22px;
                                                text-align: right;
                                                color: #8F9197;
                                                margin-left: 10px;
                                            }
                                            .tes .brd{
                                                opacity: 0.18;
                                                border: 1px solid #4D4981;
                                                padding: 0 10px;
                                                width: 100%;
                                            }
                                            .tes{
                                                display: flex;
                                                align-items: baseline;
                                                justify-content: space-between;
                                            }
                                        </style>
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

<!--                                        --><?php //if($price) {?>
<!--                                            <div class="tes" >-->
<!--                                                <ul class="colors-list">-->
<!--                                                    <li>--><?php //echo '   $'.$price ?><!--</li>-->
<!--                                                </ul>-->
<!--                                                <span class="brd"></span>-->
<!--                                                <p>Price</p>-->
<!--                                            </div>-->
<!--                                        --><?php //}?>
<!--                                        <p>$--><?php // echo $price;?><!--</p>-->
                                        <a href="#" class="btn btn-outline btn-outline-primary" style="margin-top: 20px">
                                                <b>Reserve for in-store pickup</b>
                                            </a>
                                    </div>
                                </div>
                            </div>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="text-center">-->
<!--                <a href="#" class="btn btn-xs btn-primary">Show more: 13</a>-->
<!--            </div>-->
        </div>
    </div>

    <script>
        var filtrContainer = document.getElementsByClassName('cst-filter')[0];
        var itemsForFilter = filtrContainer.getElementsByClassName('f-item');
        for(let k=0;k<itemsForFilter.length;k++){
            itemsForFilter[k].addEventListener("click", function() {
                var filterValue = this.innerText;
                var tbnInnerTextArr = filterValue.split(":");
                var btnText = tbnInnerTextArr[0];
                var getCartContainer = document.getElementsByClassName('cst-cart-items-block')[0];
                var itemsCart = getCartContainer.getElementsByClassName('products-block__item');
                for(let i=0;i<itemsCart.length;i++){
                    var catName = itemsCart[i].getElementsByClassName('product-cat-name')[0].innerText;
                    // console.log(catName+ '      -catname');
                    // console.log(btnText+ '      -btnText');
                    var current = document.getElementsByClassName("active");
                    current[0].className = current[0].className.replace(" active", "");
                    this.className += " active";
                    if(catName.trim() == btnText.trim()){
                        itemsCart[i].style.display = "block";
                    }else{
                        itemsCart[i].style.display = "none";
                    }
                }
            });
        }
        var allProduct = document.getElementsByClassName('all-product')[0];
        allProduct.addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
            var getCartContainer = document.getElementsByClassName('cst-cart-items-block')[0];
            var itemsCart = getCartContainer.getElementsByClassName('products-block__item');
            for(let i=0;i<itemsCart.length;i++){
                itemsCart[i].style.display = "block";
            }
        });
    </script>

    <div class="section">
        <div class="container">
            <div class="section__title">
                <span class="h2"><?php the_field('why_we__title__item',$id_page); ?></span>
            </div>
            <div class="cards-block">
                <?php
                $delay=0;
                 while ( have_rows('why_we',$id_page) ) : the_row();?>
                <div class="cards-block__item wow animated fadeInAnimation" data-wow-delay="<?php echo $delay; ?>s">
                        <span class="icon">
                            <img src="<?php the_sub_field('why_we__icon'); ?>" alt="">
                        </span>
                    <div class="cards-block__txt">
                        <span class="h4"><?php the_sub_field('why_we__title'); ?></span>
                        <p><?php the_sub_field('why_we__text'); ?></p>
                    </div>
                </div>
                <?php $delay+=0.1;?>
                 <?php endwhile;?>
            </div>
        </div>
    </div>

    <div class="section section-news" style="display: none">
        <div class="container">
            <?php $field=get_field('news_title', $id_page); if($field){ ?>
                <div class="section__title">
                    <span class="h2"><?php echo $field;?></span>
                </div>
            <?php }?>
                <div class="tabs-block wrap_tabs">
                    <?php
                    $this_term = get_queried_object();
                    if($this_term->category_parent===0){ ?>
                        <?php
                        $categories = get_categories( array(
                            'taxonomy'     => 'category',
                            'type'         => 'post',
                            'parent'       => '',
                            'orderby'      => 'name',
                            'order'        => 'ASC',
                            'hide_empty'   => 1,
                            'hierarchical' => 1,
                            'exclude'      => '',
                            'include'      => '',
                            'number'       => 0,
                            'pad_counts'   => false,
                        ) );

                        if( $categories ){
                            foreach( $categories as $cat ){ $term_id = $cat->term_id; ?>
                                <div class="top-text top-text__category">
                                    <div class="title-lvl-3"><?php echo $cat->name;?></div>
                                </div>

                                <div class="blog">
                                    <?php
                                    $posts = get_posts( array(
                                        'numberposts'     => -1,
                                        'category'    => $term_id,
                                        'orderby'     => 'date',
                                        'order'       => 'DESC',
                                    ) );
                                    if($posts) { ?>
                                        <?php
                                        foreach ($posts as $post) {
                                            setup_postdata($post);
                                            get_template_part( 'template/content-news' );
                                        }
                                        wp_reset_postdata();?>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    <?php }else{ ?>

                        <?php
                        $args = array(
                            'type' => 'post',
                            'orderby' => 'id',
                            'order' => 'ASC',
                            'hide_empty' => 0,
                            'hierarchical' => true,
                            'pad_counts' => false,
                        );
                        $categories = get_categories($args);
                        $count = 1;
                        if( $categories ) { ?>
                            <!--category-filter-->
                            <div class="category-filter">
                                <ul class="category-filter_content tabs-block__list">
                                    <?php foreach ($categories as $cat) { ?>
                                        <li class="tabs-block__list-item" data-filter="<?php echo $cat->term_id; ?>" <?php if($count===1){ echo ' class="active"'; }?>><?php echo $cat->name; ?></li>
                                        <?php $count++; } ?>
                                </ul>
                            </div>
                            <div class="tabs-block__content">
                                <div class="blog-filtered-content news-block">
                                    <?php $cat_this_id=$categories[0]->term_id;
                                    $posts = get_posts( array(
                                        'numberposts'     => -1, // тоже самое что posts_per_page
                                        'category'    => $categories[0]->term_id,
                                    ) );
                                    if($posts) { ?>
                                        <?php
                                        foreach ($posts as $post) {
                                            setup_postdata($post);
                                            get_template_part( 'template/content-news' );
                                        }
                                        wp_reset_postdata();?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>


                    <?php }
                    ?>
                </div>
<!--                <div class="text-center">-->
<!--                    <a href="#" class="btn btn-xs btn-primary">show more</a>-->
<!--                </div>-->
        </div>
    </div>


<!--    блок скрыт-->
    <div class="section section-philosophy" hidden>
        <div class="container">
            <div class="options">
                <div class="options-block">
                    <div class="options-block__img">
                        <img src="<?php the_field('our_philosophy_img',$id_page); ?>" alt="">
                    </div>
                    <div class="options-block__txt">
                        <span class="h2"><?php the_field('our_philosophy_title',$id_page); ?></span>
                        <p><?php the_field('our_philosophy_text',$id_page); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-news">
        <div class="container">
            <div class="section__title">
                <span class="h2">Digital news</span>
            </div>
            <div class="tabs-block">
                <div class="tabs-block__content">
                    <div class="tabs-block__box active">
                        <div class="news-block">
                            <?php $the_query = new WP_Query(
                                ['post_type' => 'post',
                                    'category_name' => 'Digital News']
                            );
                            if ($the_query->have_posts()) : ?>
                                <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                                    <?php $post_id = get_the_ID();?>
                                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id )); ?>
                                    <div class="news-block__item" style="width: 33%;">
                                <a href="#" class="news-block__link">
                                        <span class="news-block__img">
                                            <img src="<?php echo $image[0]?>" alt="">
                                        </span>
                                    <div class="news-block__txt">
<!--                                        <small>Tag name</small>-->
                                        <span class="h4"><?php the_title()?></span>
<!--                                        <p>--><?php //the_content()?><!--</p>-->
                                    </div>
                                </a>
                            </div>
                            <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
<!--                <div class="text-center">-->
<!--                    <a href="#" class="btn btn-xs btn-primary">show more</a>-->
<!--                </div>-->
            </div>
        </div>
    </div>
<?php get_footer();?>
