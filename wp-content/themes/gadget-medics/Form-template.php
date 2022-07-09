<?php
/**
 * Template Name: Form custom
 **/
?>
<?php get_header();
$id_page=get_the_ID();
?>
    <header>
        <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
        
        <a href="/" class="logo">
            <img src="<?php echo get_template_directory_uri() . '/img/logo.svg'?>" alt="Gadget Medics">
            <p><?php the_field('logo_text', $id_page); ?></p>
        </a>
        <div class="container">
            <div class="contact_info">
                <div class="contact_info_point">
                    <img src="<?php echo get_template_directory_uri() . '/img/map_point.svg'?>" alt="Gadget Medics">
                    <p><?php the_field('address', $id_page); ?></p>
                </div>
                <div class="contact_info_point phone-header">
                    <img src="<?php echo get_template_directory_uri() . '/img/phone.svg'?>" alt="Gadget Medics">
                    <p><?php the_field('phone_number', $id_page); ?></p>
                </div>
            </div>
            <div class="mobile_order_btn">
                <?php the_field('mobile_order_button', $id_page); ?>
            </div>
        </div>
    </header>
    <div class="main_screen">
        <div class="container">
            <div class="main_content">
                <div class="phone_block">
                    <div class="phone_block_title">
                        <h1><?php the_field('main_repair_price', $id_page); ?></h1>
                        <div class="currency_block"><?php the_field('main_repair_currency', $id_page); ?></div>
                    </div>
                    <div class="iphone_moving_pic">
                        <img src="<?php echo get_template_directory_uri() . '/img/iphone.png'?>" alt="Gadget Medics">
                    </div>
                </div>
                <div class="form_block">
                    <h3><?php the_field('form_title', $id_page); ?></h3>
                    <form action="#" id="mainForm" class="repairMainForm">
                        <div class="flex_container secondItemMarginMobile">
                            <input type="text" id="name" placeholder="<?php the_field('name_placeholder', $id_page); ?>" />
                            <input type="text" id="phone" placeholder="<?php the_field('phone_placeholder', $id_page); ?>" />
                            <input type="text" id="mobile_email" class="mobileMail" placeholder="<?php the_field('email_placeholder', $id_page); ?>" />
                            <input type="hidden" id="action" name="action" value="pay_form">
                        </div>
                        <div class="flex_container desktopMail">
                            <input type="text" id="desktop_email" class="fullWidthInput" placeholder="<?php the_field('email_placeholder', $id_page); ?>" />
                        </div>
                        <div class="flex_container">
                            <div class="custom-select" id="model">
                                <select name="model">
                                    <option value="" disabled="disabled" selected="selected"><?php the_field('iphone_model_placeholder', $id_page); ?></option>
                                    <?php

                                    foreach (get_field('iphones_options_main', $id_page) as $value){
                                        echo "<option value='{$value}'>{$value}</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="custom-select color-select" id="color">
                                <select name="model">
                                    <option value="" disabled="disabled" selected="selected"><?php the_field('color_placeholder', $id_page); ?></option>
                                    <?php

                                    foreach (get_field('colors_options_main', $id_page) as $value){
                                        echo "<option value='{$value}'>{$value}</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="flex_container buttonBlock">
                            <div class="triangleShown">
                                <input type="submit" id="mainFormInfo" value="<?php the_field('form_button_placeholder', $id_page); ?>"/>
                            </div>
                            <p><?php the_field('small_text_right', $id_page); ?></p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="deflector_line">
                <div class="mouse_scroll"></div>
            </div>
        </div>
    </div>
    <div class="text_block">
        <div class="container">
            <div class="flex_container">
                <div class="info_item">
                    <div class="info_item_image"><img src="<?php the_field('why_us_img1', $id_page); ?>" alt="Gadget Medics"></div>
                    <div class="info_item_title"><?php the_field('why_us_title1', $id_page); ?></div>
                    <p><?php the_field('why_us_text1', $id_page); ?></p>
                </div>
                <div class="info_item">
                    <div class="info_item_image"><img src="<?php the_field('why_us_img2', $id_page); ?>" alt="Gadget Medics"></div>
                    <div class="info_item_title"><?php the_field('why_us_title2', $id_page); ?></div>
                    <p><?php the_field('why_us_text2', $id_page); ?></p>
                </div>
                <div class="info_item">
                    <div class="info_item_image"><img src="<?php the_field('why_us_img3', $id_page); ?>" alt="Gadget Medics"></div>
                    <div class="info_item_title"><?php the_field('why_us_title3', $id_page); ?></div>
                    <p><?php the_field('why_us_text3', $id_page); ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="blurBg blurBg-select"></div>
    <div class="payment_layout">
        <div class="blurBg blurBg-payment"></div>
        <div class="payment">
            <div class="payment_block">
                <div class="close" id="closePayment"></div>
                <div class="online"><input type="submit" data-value="online" class="paymentSend" value="<?php the_field('online_pay', $id_page); ?>" /></div>
                <div class="offline"><input type="submit" data-value="offline" class="paymentSend" value="<?php the_field('offline_pay', $id_page); ?>" /></div>
            </div>
        </div>
    </div>
    <div class="success_layout">
        <div class="blurBg" style="z-index: 200; display: block; opacity: 1;"></div>
        <div class="payment">
            <div class="payment_block">
                <div class="close" id="closeSuccess"></div>
                <img src="<?php echo get_template_directory_uri() . '/img/warning.svg'?>" alt="Gadget Medics">
                <p><?php the_field('callback', $id_page); ?></p>
            </div>
        </div>
    </div>


    <div id="submitpayformajax">

    </div>
    <script src="https://js.stripe.com/v3/"></script>
<?php get_footer(); ?>