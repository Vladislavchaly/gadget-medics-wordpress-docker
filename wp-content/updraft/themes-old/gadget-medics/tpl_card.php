<?php

/*

Template Name: Card

*/

get_header(); $id_page=get_the_ID();?>

<main class="main">

            <div class="section section-scanning">
                <div class="container">
                    <div class="section__title">
                        <span class="h2"><?php the_title();?></span>
                        <?php $field=get_field('tpl_club_business__subtitle', $id_page); if($field){ ?>
                            <p> <?php echo $field;?></p>
                        <?php }?>
                    </div>
                    <div class="scanning">
                        <div class="scanning__txt">
                            <div class="scanning__txt-desktop">
                                <?php $field=get_field('scanning_text', $id_page); if($field){ ?>
                                    <span class="h2"><?php echo $field;?></span>
                                <?php }?>
                                <?php $field=get_field('scanning_text_sub', $id_page); if($field){ ?>
                                    <p><?php echo $field;?></p>
                                <?php }?>
                            </div>
                            <div class="scanning__txt-mobile">
                                <?php $field=get_field('scanning_text__mob', $id_page); if($field){ ?>
                                    <span class="h2"><?php echo $field;?></span>
                                <?php }?>
                                <?php $field=get_field('scanning_text_sub__mob', $id_page); if($field){ ?>
                                    <p><?php echo $field;?></p>
                                <?php }?>
                            </div>
                            <?php $field=get_field('qr_code', $id_page); if($field){ ?>
                                <div class="scanning__qr">
                                    <img src="<?php echo $field;?>" alt="">
                                </div>
                            <?php }?>
                            <div class="scanning__buttons">
                                <a href="<?php the_field('qr_code_link'); ?>" class="scanning__buttons-item"><img src="<?php bloginfo('template_directory')?>/img/new/appStore.svg" alt=""></a>
                                <a href="<?php the_field('qr_code_link'); ?>" class="scanning__buttons-item"><img src="<?php bloginfo('template_directory')?>/img/new/googlePlay.svg" alt=""></a>
                            </div>
                        </div>
                        <?php $field=get_field('scanning_img', $id_page); if($field){ ?>
                            <div class="scanning__img">
                                <img src="<?php echo $field;?>" alt="">
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="section section-options__inner">
                <div class="container">
                    <div class="options">
                        <div class="options-block">
                            <?php $field=get_field('punch_card__img', $id_page); if($field){ ?>
                                <div class="options-block__img">
                                    <img src="<?php echo $field;?>" alt="">
                                </div>
                            <?php }?>
                            <div class="options-block__txt">
                                <?php $field=get_field('punch_card__title', $id_page); if($field){ ?>
                                    <span class="h2"><?php echo $field;?></span>
                                <?php }?>
                                <?php $field=get_field('punch_card__text', $id_page); if($field){ ?>
                                    <p><?php echo $field;?></p>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section section-light section-cards">
                <div class="container">
                    <span class="h2"><?php the_field('club_card__title',$id_page); ?></span>
                    <div class="club-cards">
                        <?php while ( have_rows('club_cards',$id_page) ) : the_row();?>
                            <div class="club-cards__item">
                                <a href="#" class="club-cards__link">
                            <span class="club-cards__link-content">
                                <span class="club-cards__link-title"><?php the_sub_field('club_cards__title'); ?></span>
                                <span class="club-cards__link-lines">
                                    <span></span><span></span><span></span><span></span>
                                </span>
                            </span>
                                    <p><?php the_sub_field('club_cards__text'); ?></p>
                                </a>
                            </div>
                        <?php endwhile;?>
                    </div>
                </div>
            </div>
            <div class="section section-discounts">
                <div class="container">
                    <span class="h2"><?php the_field('discounts_block_title',$id_page); ?></span>
                    <div class="discounts">
                        <?php while ( have_rows('discounts',$id_page) ) : the_row();?>
                            <div class="discounts__item">
                                <a href="#" class="discounts__link">
                                    <span class="discounts__img">
                                        <img src="<?php the_sub_field('discounts_img'); ?>" alt="">
                                    </span>
                                    <span class="h3"><?php the_sub_field('discounts_title'); ?></span>
                                    <p><?php the_sub_field('discounts_text'); ?></p>
                                </a>
                            </div>
                        <?php endwhile;?>
                    </div>
                </div>
            </div>


    <?php get_footer(); ?>


