<?php

/*

Template Name: referral

*/

get_header(); $id_page=get_the_ID();?>

<main class="main">
    <div class="section section-welcome section-welcome__referral">
        <div class="container">
            <div class="welcome-block welcome-block__referral">
                <div class="welcome-block__txt">
                    <span class="h2"><?php the_title();?></span>
                    <?php $field=get_field('referral_text_small', $id_page); if($field){ ?>
                        <small><?php echo $field;?></small>
                    <?php }?>
                    <?php $field=get_field('referral__text', $id_page); if($field){ ?>
                        <p><?php echo $field;?></p>
                    <?php }?>
                </div>
                <div class="welcome-block__form">
                    <span class="h3"><?php the_field('title_referral_form', $id_page); ?></span>
                    <?php echo do_shortcode('[fluentform id="3"]');?>
                    <small><?php the_field('welcome_form_small_text','options'); ?></small>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>


