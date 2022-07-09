<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); $id_page=get_the_ID(); ?>

    <main class="main">
        <div class="section">
            <div class="container">
                <div class="section__title">
                    <span class="h2"><?php the_title();?></span>
                </div>
                <div class="article">
                    <?php
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            the_content();
                        }
                    }
                    ?>
                </div>
            </div>
    </div>

<?php get_footer();?>