<?php

/*

Template Name: Boca Raton

*/

get_header(); $id_page=get_the_ID();?>

<main class="main">

    <div class="section section-options__warranty">
        <div class="container">
            <div class="options">
                <div class="options-block">
                    <div class="options-block__txt">
                        <span class="h2"><?php the_field('boca_raton_top_title',$id_page); ?></span>
                        <p><?php the_field('boca_raton_top_text',$id_page); ?></p>
                    </div>
                    <div class="options-block__img">
                        <img src="<?php the_field('boca_raton_top_img',$id_page); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-light section-text">
        <div class="container">
            <div class="text">
                <span class="h4"><?php the_field('boca_raton_center_title',$id_page); ?></span>
                <p><?php the_field('boca_raton_center_text',$id_page); ?></p>
            </div>
        </div>
    </div>
    <div class="section section-options__inner section-options__inner-reverse">
        <div class="container">
            <div class="options">
                <div class="options-block">
                    <?php $field=get_field('boca_raton_img_1', $id_page); if($field){ ?>
                        <div class="options-block__img">
                            <img src="<?php echo $field;?>" alt="">
                        </div>
                    <?php }?>
                    <div class="options-block__txt">
                        <?php $field=get_field('boca_raton_title_1', $id_page); if($field){ ?>
                            <span class="h2"><?php echo $field;?></span>
                        <?php }?>
                        <?php $field=get_field('boca_raton_text_1', $id_page); if($field){ ?>
                            <p><?php echo $field;?></p>
                        <?php }?>
                    </div>
                </div>
                <div class="options-block">
                    <?php $field=get_field('boca_raton_img_2', $id_page); if($field){ ?>
                        <div class="options-block__img">
                            <img src="<?php echo $field;?>" alt="">
                        </div>
                    <?php }?>
                    <div class="options-block__txt">
                        <?php $field=get_field('boca_raton_title_2', $id_page); if($field){ ?>
                            <span class="h2"><?php echo $field;?></span>
                        <?php }?>
                        <?php $field=get_field('boca_raton_text_2', $id_page); if($field){ ?>
                            <p><?php echo $field;?></p>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-options__centered">
        <div class="container">
            <div class="options">
                <div class="options-block">
                    <?php $field=get_field('boca_raton_img_3', $id_page); if($field){ ?>
                        <div class="options-block__img">
                            <img src="<?php echo $field;?>" alt="">
                        </div>
                    <?php }?>
                    <div class="options-block__txt">
                        <?php $field=get_field('boca_raton_title_3', $id_page); if($field){ ?>
                            <span class="h2"><?php echo $field;?></span>
                        <?php }?>
                        <?php $field=get_field('boca_raton_text_3', $id_page); if($field){ ?>
                            <p><?php echo $field;?></p>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section section-options__inner">
        <div class="container">
            <div class="options">
                <div class="options-block">
                    <?php $field=get_field('boca_raton_img_4', $id_page); if($field){ ?>
                        <div class="options-block__img">
                            <img src="<?php echo $field;?>" alt="">
                        </div>
                    <?php }?>
                    <div class="options-block__txt">
                        <?php $field=get_field('boca_raton_title_4', $id_page); if($field){ ?>
                            <span class="h2"><?php echo $field;?></span>
                        <?php }?>
                        <?php $field=get_field('boca_raton_text_4', $id_page); if($field){ ?>
                            <p><?php echo $field;?></p>
                        <?php }?>
                    </div>
                </div>
                <div class="options-block">
                    <?php $field=get_field('boca_raton_img_5', $id_page); if($field){ ?>
                        <div class="options-block__img">
                            <img src="<?php echo $field;?>" alt="">
                        </div>
                    <?php }?>
                    <div class="options-block__txt">
                        <?php $field=get_field('boca_raton_title_5', $id_page); if($field){ ?>
                            <span class="h2"><?php echo $field;?></span>
                        <?php }?>
                        <?php $field=get_field('boca_raton_text_5', $id_page); if($field){ ?>
                            <p><?php echo $field;?></p>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer(); ?>


