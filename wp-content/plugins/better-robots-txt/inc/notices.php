<?php

function rt_notice_subscribe()
{
    $user_id = get_current_user_id();
    $purchase_url = "options-general.php?page=better-robots-txt-pricing";
    $getpro = sprintf( wp_kses( __( 'Better Robotstxt - Boost your Google ranking with <a href="%s" target="_blank">Better Robots.txt PRO</a> plugin | Get 10&#37; OFF if you subscribe here:', 'better-robots-txt' ), array(
        'a' => array(
        'href'   => array(),
        'target' => array(),
    ),
    ) ), esc_url( $purchase_url ) );
    
    if ( !get_user_meta( $user_id, 'rt-subscribe-dismiss' ) ) {
        ?>
    
        <div class="notice rt-notice notice-success is-dismissible subscribe-notice">
            <p class="rt-p"><?php 
        echo  $getpro ;
        ?></p>
            <form action="https://Pagup.us14.list-manage.com/subscribe/post?u=a706b8e968389b05725c65849&amp;id=9c762f94b8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate rt-form-notice" target="_blank" novalidate>
    
            <input type="email" value="" name="EMAIL" class="rt-field-notice" placeholder="<?php 
        echo  __( 'Email address', 'better-robots-txt' ) ;
        ?>" required>
    
            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_a706b8e968389b05725c65849_b802a7a540" tabindex="-1" value=""></div>
            <div class="clear rt-clear-notice"><input type="submit" value="<?php 
        echo  __( 'Subscribe', 'better-robots-txt' ) ;
        ?>" name="subscribe" id="mc-embedded-subscribe" class="rt-btn-notice"></div>
    
            </form>
        </div>
    
        <?php 
    }

}

add_action( 'admin_notices', 'rt_notice_subscribe' );
function rt_notice_rate()
{
    $user_id = get_current_user_id();
    
    if ( !get_user_meta( $user_id, 'rt-rating-dismiss' ) ) {
        ?>
            <div class="notice rt-notice notice-success is-dismissible rating-notice">
                <p class="rt-p">
                    <?php 
        $rating_url = "https://wordpress.org/support/plugin/better-robots-txt/reviews/?rate=5#new-post";
        $show_support = sprintf( wp_kses( __( 'Show support for Better Robots.txt with a 5-star rating » <a href="%s" target="_blank">Click here</a>', 'better-robots-txt' ), array(
            'a' => array(
            'href'   => array(),
            'target' => array(),
        ),
        ) ), esc_url( $rating_url ) );
        echo  $show_support ;
        ?>
                </p>
            </div>
        <?php 
    }

}

add_action( 'admin_notices', 'rt_notice_rate' );
// DISMISS NOTICE CALL TO AJAX
function rt_notice_dismissed()
{
    $user_id = get_current_user_id();
    if ( isset( $_POST['multisite_dismiss'] ) ) {
        add_user_meta(
            $user_id,
            'rt-multisite-dismiss',
            'true',
            true
        );
    }
    if ( isset( $_POST['subscribe_dismiss'] ) ) {
        add_user_meta(
            $user_id,
            'rt-subscribe-dismiss',
            'true',
            true
        );
    }
    if ( isset( $_POST['rating_dismiss'] ) ) {
        add_user_meta(
            $user_id,
            'rt-rating-dismiss',
            'true',
            true
        );
    }
    wp_die();
}

add_action( 'wp_ajax_rt_notice_dismissed', 'rt_notice_dismissed' );