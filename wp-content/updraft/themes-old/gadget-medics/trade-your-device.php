<?php
/**
 * Template Name: Trade-In your device
 **/
?>
<?php get_header(); ?>
<div class="wrapper">
    <div class="overlay"></div>
    <!-- header структура не изменилась, только стили >>>-->
<!--    <header class="header">-->
<!--        <div class="header-main">-->
<!--            <div class="container">-->
<!--                <div class="header-main__block">-->
<!--                    <span class="header-main__location">20449 State Road 7, STE A-6 Boca Raton, FL 33498</span>-->
<!--                    <span class="header-main__worktime">Open <b>now</b> - until <b>7 PM</b></span>-->
<!--                    <div class="header-main__contacts">-->
<!--                        <span>Call or text: <a href="tel:5612796888">561 279 6888</a></span>-->
<!--                        <a href="#" class="btn btn-primary">Franchising</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="header-navigation">-->
<!--            <div class="container">-->
<!--                <div class="header-navigation__block">-->
<!--                    <a href="#" class="logo">Gadget Medics</a>-->
<!--                    <div class="header-navigation__menu">-->
<!--                        <ul>-->
<!--                            <li class="active"><a href="#">Home</a></li>-->
<!--                            <li><a href="#">Broken Club</a></li>-->
<!--                            <li><a href="#">Partnership</a></li>-->
<!--                            <li><a href="#">Warranty</a></li>-->
<!--                            <li><a href="#">Referral program</a></li>-->
<!--                            <li><a href="#">About Us</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                    <button class="header-menu__btn">-->
<!--                        <span></span>-->
<!--                        <span></span>-->
<!--                        <span></span>-->
<!--                    </button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </header>-->

    <main class="main">
        <div class="section section__inner" style="padding: 55px 0  0 0 ">
            <div class="container">
                <div class="section__title">
                    <span class="h2">Trade-In Your Device</span>
                    <p>You have a sick device but don't have time to call around to explain the problem? Not a big deal. Call Gadget Medics today for a free of charge on-the-spot diagnostic.</p>
                </div>
                <div class="trade-block">
                    <div class="trade-block__item">
                        <a href="https://gadgetmedics.com/trade-in-iphone/" class="trade-block__link">
                            <span class="trade-block__img">
                                <span class="trade-block__img-visible">
                                    <img src="<?php echo get_template_directory_uri() . '/img/trade/1.svg'?>" alt="">
                                </span>
                                <span class="trade-block__img-hidden">
                                    <img src="<?php echo get_template_directory_uri() . '/img/trade/a-1.svg'?>" alt="">
                                </span>
                            </span>
                            <span class="trade-block__title">iPhone</span>
                        </a>
                    </div>
                    <div class="trade-block__item">
                        <a href="https://gadgetmedics.com/trade-in-ipad/" class="trade-block__link">
                            <span class="trade-block__img">
                                <span class="trade-block__img-visible">
                                     <img src="<?php echo get_template_directory_uri() . '/img/trade/2.svg'?>" alt="">
                                </span>
                                <span class="trade-block__img-hidden">
                                    <img src="<?php echo get_template_directory_uri() . '/img/trade/a-2.svg'?>" alt="">
                                </span>
                            </span>
                            <span class="trade-block__title">iPad</span>
                        </a>
                    </div>
                    <div class="trade-block__item">
                        <a href="#" class="trade-block__link">
                            <span class="trade-block__img">
                                <span class="trade-block__img-visible">
                                    <img src="<?php echo get_template_directory_uri() . '/img/trade/3.svg'?>" alt="">
                                </span>
                                <span class="trade-block__img-hidden">
                                    <img src="<?php echo get_template_directory_uri() . '/img/trade/a-3.svg'?>" alt="">
                                </span>
                            </span>
                            <span class="trade-block__title">Mac Computers</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </main>

</div>
    <style>
        .section.section-contact{
            margin-top: 0!important;
        }
    </style>
<?php get_footer(); ?>