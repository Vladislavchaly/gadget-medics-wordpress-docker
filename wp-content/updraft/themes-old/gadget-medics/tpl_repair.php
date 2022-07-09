<?php

/*

Template Name: reviews

*/

get_header(); $id_page=get_the_ID();?>

<main class="main">
    <div class="section section-welcome">
        <div class="container">
            <span class="h1"><?php the_title();?></span>
            <div class="welcome-block">
                <div class="welcome-block__form">
                    <span class="h3"><?php the_field('welcome_form_title','options'); ?></span>
                    <?php echo do_shortcode('[fluentform id="2"]');?>
                    <small><?php the_field('welcome_form_small_text','options'); ?></small>
                </div>
                <div class="welcome-block__img">
                    <span class="welcome-block__img-wrapper">
                        <img src="<?php the_post_thumbnail_url();?>">
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="cards-block">
                <?php
                $delay=0;
                while ( have_rows('repair',$id_page) ) : the_row();?>
                    <div class="cards-block__item wow animated fadeInAnimation" data-wow-delay="<?php echo $delay; ?>s">
                        <span class="icon">
                            <img src="<?php the_sub_field('repair_icon'); ?>" alt="">
                        </span>
                        <div class="cards-block__txt">
                            <span class="h4"><?php the_sub_field('repair_title'); ?></span>
                            <p><?php the_sub_field('repair_text'); ?></p>
                        </div>
                    </div>
                <?php $delay+=0.1;?>
                <?php endwhile;?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>

