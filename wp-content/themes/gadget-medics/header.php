<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
	<meta name="google-site-verification" content="g-YL9ViVuSYTVcgPV0wRfFGyWsQugSHovtRPxKqMAik" />
<!--    <title>--><?php //wp_title(''); ?><!--</title>-->
	<?php wp_head();?>

    <script>
        var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
    </script>

	<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(50358514, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/50358514" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-92227679-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-92227679-1');
</script>

</head>
<body>
<div class="wrapper">
    <div class="overlay"></div>

<?php if ( !is_page( 760 ) ) { ?>

    <header class="header">
        <div class="header-main" id="headermain">
            <div class="container">
                <div class="header-main__block">
                    <a href="<?php the_field('view_on_map','options'); ?>" target="_blank" class="header-main__location"><?php the_field('location','options'); ?></a>
                    <?php
                    $monday = get_option('monday_status_option');
                    $mondayend = get_option('mondayend_status_option');
                    $tuesday = get_option('tuesday_status_option');
                    $tuesdayend = get_option('tuesdayend_status_option');
                    $wednesday = get_option('wednesday_status_option');
                    $wednesdayend = get_option('wednesdayend_status_option');
                    $thursday = get_option('thursday_status_option');
                    $thursdayend = get_option('thursdayend_status_option');
                    $fridays = get_option('fridays_status_option');
                    $fridaysend = get_option('fridaysend_status_option');
                    $saturday = get_option('saturday_status_option');
                    $saturdayend = get_option('saturdayend_status_option');
                    $sunday = get_option('sunday_status_option');
                    $sundayend = get_option('sundayend_status_option');
                        $storeSchedule = [
                            'Sun' => ["$sunday AM" => "$sundayend PM"],
                            'Mon' => ["$monday AM" => "$mondayend PM"],
                            'Tue' => ["$tuesday AM" => "$tuesdayend PM"],
                            'Wed' => ["$wednesday AM" => "$wednesdayend PM"],
                            'Thu' => ["$thursday AM" => "$thursdayend PM"],
                            'Fri' => ["$fridays AM" => "$fridaysend PM"],
                            'Sat' => ["$saturday AM" => "$saturdayend PM"]
                        ];
                        $timestamp = current_time('timestamp');
//                        $status = '<span class="closed">Closed </span>';
                    $preg = "{3,}";
                    ////////////////
                    ///
                    $weekdaytrue = date('D');
                    $Mon = get_option('eg_setting_name2');
                    $Tue = get_option('eg_setting_name3');
                    $Wed = get_option('eg_setting_name4');
                    $Thu = get_option('eg_setting_name5');
                    $Fri = get_option('eg_setting_name6');
                    $Sat = get_option('eg_setting_name7');
                    $Sun = get_option('eg_setting_name9');
                    $weekday = array($Mon, $Tue, $Wed, $Thu, $Fri, $Sat, $Sun);
                    $closed = get_option('close_status_option');
                    $closednew = get_option('eg_setting_name_close');
                    if (isset($weekday)){
                        if (in_array($weekdaytrue, $weekday)){
//                            if (preg_match($preg,$closednew)) {
                            if (!empty($closednew)){
                                $status = "<span class='closed'>$closednew</span>";
                            }else{
                                $status = '<span class="closed">' . trim($closed) . '</span>';
                            }
                        }else{
                            $status = '<span class="closed">' . trim($closed) . '</span>';
                        }
                    }


                    ///////////////////
//                    $status = '<span class="closed">' . trim($closed) . '</span>';
                        $status_time = '<b>10 AM</b>';
                        $currentTime = (new DateTime())->setTimestamp($timestamp);
                        foreach ($storeSchedule[date('D', $timestamp)] as $startTime => $endTime) {
                            $startTime = DateTime::createFromFormat('h:i A', $startTime);
                            $endTime   = DateTime::createFromFormat('h:i A', $endTime);
                            if (($startTime < $currentTime) && ($currentTime < $endTime)) {
                                $open = get_option('open_status_option');
                                $opennew = get_option('eg_setting_name_open');
                                if (isset($weekday)){
                                    if (in_array($weekdaytrue, $weekday)){
                                        if (!empty($closednew)){
                                        $status = "<span class='open'>$opennew</span>";}
                                        else{
                                            $status = '<span class="open">' . $open. '</span>';
                                        }
                                    }else{
                                        $status = '<span class="open">' . $open. '</span>';
                                    }
                                }
//                                $status = '<span class="open">' . $open. '</span>';
                                $status_time = '<b>7 PM</b>';
                                break;
                            }
                        }
//                        echo "<span class=\"header-main__worktime\">$status  - until $status_time   $mondays</span>";
                    echo "<span class=\"header-main__worktime\">$status</span>";
//                    echo print_r($currentTime);
                    ?>
                    
                    <div class="header-main__contacts">
                        <span>Call or text: <a href="tel:<?php the_field('phone_link','options'); ?>"><?php the_field('phone','options'); ?></a></span>
                        <!--<a href="#" class="btn btn-primary">Franchising</a>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="header-navigation">
            <div class="container">
                <div class="header-navigation__block">
                    <a href="<?php echo get_home_url(); ?>" class="logo"><?php the_field('logo','options'); ?></a>
                    <div class="header-navigation__menu">
                        <?php wp_nav_menu( array( 'menu_class'      => 'menu','container'       => false, 'theme_location' => 'primary' ) ); ?>
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

    <?php } ?>