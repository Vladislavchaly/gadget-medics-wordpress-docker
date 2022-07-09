<div class="section section-light section-contact">
    <div class="container">
        <span class="h2"><?php the_field('contact_us_title','options'); ?></span>
        <div class="contact-block">
            <div class="contact-block-form">
                <?php echo do_shortcode('[fluentform id="4"]');?>
            </div>
            <div class="contact-block-txt">
                <div class="contact-block-txt__item">
                    <span class="contact-block-txt__location"><?php the_field('location','options'); ?></span>
                    <a href="<?php the_field('view_on_map','options'); ?>" target="_blank">View on map</a>
                </div>
                <div class="contact-block-txt__item">
                    <a href="tel:<?php the_field('phone_link','options'); ?>" class="btn btn-secondary btn-phone"><?php the_field('phone','options'); ?></a>
                    <a href="mailto:<?php the_field('email_link','options'); ?>" class="btn btn-secondary btn-mail"><?php the_field('email','options'); ?>Email Us</a>
                </div>
                <?php if( have_rows('social','options') ):?>
                    <div class="social">
                        <?php while ( have_rows('social','options') ) : the_row();?>
                            <a target="_blank" href="<?php the_sub_field('social_link'); ?>" class="social__link"><img src="<?php the_sub_field('social_icon'); ?>" alt="Gadget Medics on Social" /></a>
                        <?php endwhile;?>
                    </div>
                <?php  endif; ?>
            </div>
        </div>
    </div>
</div>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-main__description">
                <span class="h3"><?php the_field('logo','options'); ?></span>
                <p><?php the_field('description_footer','options'); ?></p>
            </div>
            <div class="footer-main__menu">
                <span class="h4"><?php the_field('footer_title_menu_first','options'); ?></span>
                <?php wp_nav_menu( array( 'menu_class'      => 'menu','container'       => false, 'theme_location' => 'primary' ) ); ?>
            </div>
            <div class="footer-main__menu">
                <span class="h4"><?php the_field('footer_title_menu_second','options'); ?></span>
                <?php wp_nav_menu( array( 'menu_class'      => 'menu','container'       => false, 'repair' => 'Menu repair' ) ); ?>
            </div>
        </div>
        <div class="copyrights"><?php the_field('copyright_before_heart','options'); ?><img src="<?php bloginfo('template_directory')?>/img/icons/icon-heart.svg" alt=""><?php the_field('copyright_after_heart','options'); ?></div>
    </div>
</footer>

</div>

<div class="modal" id="modalDate">
    <div class="h4">Buy in store</div>
    <?php echo do_shortcode('[fluentform id="7"]');?>
</div>
<div class="modal" id="modalDateAddress">
    <div class="h4">Buy in store</div>
    <?php echo do_shortcode('[fluentform id="8"]');?>
</div>

<?php wp_footer();?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>
