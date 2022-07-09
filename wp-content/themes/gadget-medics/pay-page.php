<?php
/*

Template Name: pay page

*/

get_header(); $id_page=get_the_ID(); ?>

<main class="main">

    <div class="section-pay">
        <div class="container">
            <?php echo get_field('title'); ?>
        </div>
    </div>
    <div class="section-pay-form">
        <div class="container">
        <?php echo do_shortcode('[fluentform id="11"]');?>
        </div>
    </div>
<?php get_footer();?>
