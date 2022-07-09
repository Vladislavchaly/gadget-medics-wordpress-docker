<?php

/*

Template Name: club and business

*/

get_header(); $id_page=get_the_ID();?>

<main class="main">
    <div class="section">
        <div class="container">
            <div class="section__title">
                <span class="h2"><?php the_title();?></span>
                <?php $field=get_field('tpl_club_business__subtitle', $id_page); if($field){ ?>
                    <p> <?php echo $field;?></p>
                <?php }?>
            </div>
            <div class="cards-block">
                <?php
                $delay=0;
                while ( have_rows('club_business',$id_page) ) : the_row();?>
                <div class="cards-block__item wow animated fadeInAnimation" data-wow-delay="<?php echo $delay; ?>s">
                        <span class="icon">
                            <img src="<?php the_sub_field('club_business_icon'); ?>" alt="">
                        </span>
                    <div class="cards-block__txt">
                        <span class="h4"><?php the_sub_field('club_business__title'); ?></span>
                        <p><?php the_sub_field('club_business__text'); ?></p>
                    </div>
                </div>
                <?php $delay+=0.1;?>
                <?php endwhile;?>
            </div>


            <?php $field=get_field('tpl_club_business__subtitle_btm', $id_page); if($field){ ?>
                <div class="section__subtitle">
                    <p> <?php echo $field;?></p>
                </div>
            <?php }?>

        </div>
    </div>
<?php get_footer(); ?>


