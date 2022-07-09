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
<!--                --><?php //while ( have_rows('repair_options',$id_page) ) : the_row();?>
<!--                    <div class="options-block">-->
<!--                        <div class="options-block__img">-->
<!--                            <img src="--><?php //the_sub_field('repair_options__img'); ?><!--" alt="">-->
<!--                        </div>-->
<!--                        <div class="options-block__txt">-->
<!--                            <span class="h4">--><?php //the_sub_field('repair_options__title'); ?><!--</span>-->
<!--                            <p>--><?php //the_sub_field('repair_options__text'); ?><!--</p>-->
<!--                            <a href="#" class="btn btn-xs btn-primary" data-fancybox data-src="#--><?php //the_sub_field('repair_options__modal'); ?><!--">Buy in store</a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                --><?php //endwhile;?>
                <div class="options-block">
                    <div class="options-block__img">
                        <img src="https://gadgetmedics.com/wp-content/uploads/2019/04/repairOption1.svg" alt="">
                    </div>
                </div>
                <div class="options-block">
                    <div class="options-block__txt">
                        <span class="h4">Visit our repair center</span>
                        <p>20449 State Road 7, STE A6 Boca Raton, FL 33498</p>
                        <p>1906 Clint Moore Rd, STE 5 Boca Raton, FL 33496</p>
                    </div>
                </div>
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
                        <span class="h4"><?php if (!empty(get_sub_field('why_we__url'))){ echo "<a style='color: #222;' href='".get_sub_field('why_we__url')."'>".get_sub_field('why_we__title')."</a>";}else{ ?><?php the_sub_field('why_we__title'); }?></span>
                        <p><?php the_sub_field('why_we__text'); ?></p>
                    </div>
                </div>
                <?php $delay+=0.1;?>
                 <?php endwhile;?>
            </div>
        </div>
    </div>

<!--    <div class="section section-news">-->
<!--        <div class="container">-->
<!--            <div class="section__title">-->
<!--                <span class="h2">Digital news</span>-->
<!--            </div>-->
<!--	--><?php
//	$posts = get_posts( array(
//		'numberposts' => -1,
//		'category'    => 93,
//		'orderby'     => 'date',
//		'order'       => 'DESC',
//		'include'     => array(),
//		'exclude'     => array(),
//		'meta_key'    => '',
//		'meta_value'  =>'',
//		'post_type'   => 'post',
//		'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
//	) );
//?>
<!---->
<!--    <div class="main-slider-news">-->
<!--        <div class="slider-news-block">--><?php
//            $first = "first";
//	foreach( $posts as $post ){
//		$post_id = get_the_ID();
//		$thumbnail_id = get_post_thumbnail_id( $post_id );
//		$image = wp_get_attachment_image_src( $thumbnail_id , 'Large');
//		setup_postdata($post);?>
<!--            <div class="news-block__item --><?php //echo $first; ?><!--">-->
<!--		<a href=" --><?php //echo get_permalink(); ?><!-- " class="link-news-post">-->
<!--		<img src=" --><?php //echo $image[0]; ?><!--" class="image-post-link">-->
<!--		<div class="content-news-post">-->
<!--            <h4 class="title-news-post"> --><?php //echo get_the_title(); ?><!--</h4>-->
<!--		<p class="content-short-news-post" >--><?php //echo mb_strimwidth(get_the_excerpt(''), 0,65); ?><!--</p>-->
<!--        </div>-->
<!--        </a>-->
<!--            </div>-->
<!--    --><?php
//        $first = "";
//	}?>
<!--        </div>-->
<!--    </div>--><?php
//
//	wp_reset_postdata(); // сброс
//	?>
<!--        </div>-->
<!--    </div>-->
<?php get_footer();?>
