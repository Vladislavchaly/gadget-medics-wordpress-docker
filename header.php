<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo wp_get_document_title(); ?></title>
    <?php wp_head();?>
</head>
<body>
<div class="wrapper">
    <div class="overlay"></div>

    <header class="header">
        <div class="header-main">
            <div class="container">
                <div class="header-main__block">
                    <span class="header-main__location">20449 State Road 7, STE A-6 Boca Raton, FL 33498</span>
                    <span class="header-main__worktime">Open <b>now</b> - until <b>7 PM</b></span>
                    <div class="header-main__contacts">
                        <span>Call or text: <a href="tel:5612796888">561 279 6888</a></span>
                        <a href="#" class="btn btn-primary">Franchising</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-navigation">
            <div class="container">
                <div class="header-navigation__block">
                    <a href="#" class="logo">Gadget Medics</a>
                    <div class="header-navigation__menu">
                        <ul>
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="#">Broken Club</a></li>
                            <li><a href="#">Partnership</a></li>
                            <li><a href="#">Warranty</a></li>
                            <li><a href="#">Referral program</a></li>
                            <li><a href="#">About Us</a></li>
                        </ul>
                    </div>
                    <button class="header-menu__btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="header">
        <div>
            <div class="top_head">
                <a href="<?php echo get_home_url(); ?>" class="logo">
                    <p><?php echo get_bloginfo( 'name');?></p>
                    <span><?php echo get_bloginfo( 'description');?></span>
                </a>
                <a href="<?php echo get_home_url(); ?>" class="logo"><img src="<?php the_field('logo','options'); ?>/img/logo.jpg" alt=""/> </a>
                <a href="#" class="call_back">заказать звонок</a>
                <a href="tel:<?php the_field('phone_link','options'); ?>" class="phone"><?php the_field('phone','options'); ?>+7 (499) 642-55-45</a>
            </div>
        </div>
    </div>
