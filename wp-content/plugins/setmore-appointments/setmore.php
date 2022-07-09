<?php

/*
Plugin Name: Setmore Appointments
Plugin URI: https://www.setmore.com/
Description: Setmore Appointments ��� Take customer appointments online for free
Version: 2.0
Author: Setmore Appointments
Author URI: https://www.setmore.com/
License: GPL
*/
/*===========================================
Do the work, create a database field
===========================================*/

function register_plugin_settings() {
//register our settings
register_setting( 'register-settings-group', 'setmore_booking_page_url' );
// register_setting( 'register-settings-group', 'setmore_booking_page_text' );
// register_setting( 'register-settings-group', 'buttonOption', $args);
	 $args = array(
            'type' => 'string',
        'description'       => '',
        'show_in_rest' => array(
                'name' => 'languageOption',
            ),
            'default'      => 'English',
            );
register_setting( 'register-settings-group', 'languageOption',$args);
}
/*===========================================
Create an admin menu to me loaded
===========================================*/

if ( is_admin() ){
/* Call the html code */
add_action('admin_menu', 'setmore_admin_menu');

function setmore_admin_menu() {
add_action( 'admin_init', 'register_plugin_settings' );
$page_title = 'Setmore Booking Appointments';
$menu_title = 'Setmore';
$capability = 'manage_options';
$menu_slug  = 'setmoreBookingAppointments';
$function   = 'setmore_extra_menu_info_page';
$icon_url   = get_bloginfo('wpurl').'/wp-content/plugins/setmore-appointments/setmore.png';
$position   = 35;

add_menu_page( $page_title,
$menu_title,
$capability,
$menu_slug,
$function,
$icon_url,
$position );
}
}
/*===========================================
Add all the necessary dependencies
===========================================*/
add_action('init','initialize_setmore');
add_action('init','init_shortCode');
add_action("plugins_loaded", "setmore_widget_init");

function initialize_setmore() {
// Javascripts
// wp_deregister_script('jquery');
wp_register_script('jquery',	'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
wp_enqueue_script('jquery');
wp_enqueue_script('setmore');
wp_enqueue_style( 'sm-wordpress', get_bloginfo('wpurl').'/wp-content/plugins/setmore-appointments/sm-wordpress.css',false,'1.1','all');
// wp_enqueue_script( 'myJavaScript', get_bloginfo('wpurl').'/wp-content/plugins/setmore-appointments/setmoreFormScript.js',false,'1.1','all');

}

function init_shortCode(){
//added as default button
add_shortcode( 'setmore', 'addIframe_setmore' );
}

function addIframe_setmore(){
$bookingPageUrl = get_option('setmore_booking_page_url');
$bookingButtonName = get_option('setmore_booking_page_text');
$bookingButtonLang = get_option('languageOption');
$url = $bookingPageUrl."?lang=".$bookingButtonLang;
$i = '<p><script id="setmore_script" type="text/javascript" src="'.get_bloginfo("wpurl").'"/wp-content/plugins/setmore-appointments/script/setmoreFancyBox.js"></script><a id="Setmore_button_iframe" style="float:none" href='.$url.'> <img border="none" src="https://my.setmore.com/images/bookappt/SetMore-book-button.png" alt="Book an appointment with Personnel Calendar using SetMore" /></a></p>';
return $i;
}

function setmore_widget_init() {
add_action('widgets_init', 'setmore_widget_load_widgets');
}

function setmore_widget_load_widgets() {
require_once('setmore_widget.php');
register_widget('setmore_widget');
}

/*===========================================
SetMore HTML page
===========================================*/
if( !function_exists("setmore_extra_menu_info_page") )
{
function setmore_extra_menu_info_page(){
	$scriptUrl = get_bloginfo("wpurl");
?>
<style>
		@font-face {
  font-family: "lato";
  src: url("<?php echo $scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Regular.woff2") format("woff2"),
    url("<?php echo $scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Regular.woff") format("woff"),
    url("<?php echo $scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Regular.ttf") format("ttf");
  font-weight: 400;
  font-style: normal;
}
@font-face {
  font-family: "lato";
  src: url("<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Medium.woff2") format("woff2"),
    url("<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Medium.woff") format("woff"),
    url("<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Medium.ttf") format("ttf");
  font-weight: 500;
  font-style: normal;
}
@font-face {
  font-family: "lato";
  src: url("<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Semibold.woff2") format("woff2"),
    url("<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Semibold.woff") format("woff"),
    url("<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/fonts/lato/Lato-Semibold.ttf") format("ttf");
  font-weight: 600;
  font-style: normal;
}
</style>
<form method="post" action="options.php">
<?php settings_fields( 'register-settings-group' ); ?>
<?php do_settings_sections( 'register-settings-group' ); ?>
<main class="sm-integration-container">
<h2>Setmore Appointment</h2>
<div class="sm-getstarted">
<p>
Let customers book appointments from your website and convert visitors into customers. Add your Setmore account details below, then go to Appearance > Widgets in WordPress to place the button on your website. <a href="https://support.setmore.com/integrations/wordpress" target="_blank"> Learn more> </a>
</p>
<div>
<input class="btn btn-login" type="button" value="Login" siteUrl="<?php echo get_bloginfo('wpurl');?>"/> or <a href="https://www.setmore.com/start-now"
target="_blank" class="btn btn-signup">
Sign Up</a>to get started.
</div>
</div>
<div class="sm-acc-info">

<h4>Account Information</h4>
<ul>
<li>
<label>Booking Page URL</label>
<input id="setmore_booking_page_url"
type="text" autocomplete="off"
placeholder="Enter your url"
	   name="setmore_booking_page_url"
	   value="<?php echo get_option('setmore_booking_page_url')  ?>"

/>
</li>
<li>
<label>Booking Page Language</label>
<div class="sm-dropdown">
<?php $setmore_booking_page_language = empty( get_option('languageOption') ) ? "English" : get_option('languageOption'); ?>
<a><input id="languageOption" autocomplete="off" name="languageOption" value ="<?php echo $setmore_booking_page_language?>"/><i class ="fa fa-sort-down" id="dropDown" style ='background-image: url("<?php echo $scriptUrl ?>/wp-content/plugins/setmore-appointments/arrow-down.png");'></i></a>
<ul class="langaugeList">
<li>Arabic</li>
<li>Bulgarian</li>
<li>Czech</li>
<li>Croatia</li>
<li>Danish</li>
<li>Dutch</li>
<li>English</li>
<li>Estonian</li>
<li>French</li>
<li>Finnish</li>
<li>German</li>
<li>Greek</li>
<li>Hebrew</li>
<li>Hungarian</li>
<li>Italian</li>
<li>Icelandic</li>
<li>Japanese</li>
<li>Korean</li>
<li>Latin</li>
<li>Latvian</li>
<li>Lithuanian</li>
<li>Norwegian</li>
<li>Polish</li>
<li>Portuguese</li>
<li>Romanian</li>
<li>Russian</li>
<li>Serbian</li>
<li>Slovenian</li>
<li>Spanish</li>
<li>Swedish</li>
<li>Turkish</li>
<li>Ukrainian</li>
</ul>
</div>
</li>
<!-- <li>
<label>CTA Button Text</label>
<input id="setmore_cta_text"
type="text" autocomplete="off"
placeholder="Enter your CTA button text"
	   name="setmore_cta_text"
	   value="<?php echo get_option('setmore_booking_page_text')  ?>"

/>
</li> -->
</ul>
</div>
</main>
<?php submit_button(); ?>
</form>
<br />
<main class="sm-integration-container">
<div class="sm-faq">
        <h4>Frequently Asked Questions</h4>
        <ul>
          <li>
            <h5>1. What is Setmore?</h5>
            <p> <b>
              Once you add your Setmore account details to the form fields above, use the Widget menu to add the Setmore widget anywhere on your site.
            </b></p>
          </li>
          <li>
            <h5>2. How does the widget work?</h5>
            <p>
              Once you add your Setmore account details below, use the Widget
              menu to add the Setmore widget anywhere on your site.
            </p>
          </li>
          <li>
            <h5>3. Where can I find my Booking Page URL?</h5>
            <p>
              Log into the Setmore web app at <a href="https://my.setmore.com" target="_blank">https://my.setmore.com</a> and navigate to Settings > Booking Page.
            </p>
          </li>
          <li>
            <h5>4. How do I make changes to the Booking Page?</h5>
            <p>
              Log into the Setmore web app at <a href="https://my.setmore.com" target="_blank">https://my.setmore.com</a>. You can update services, staff, availability, and appearance under Settings.
            </p>
          </li>
          <li>
            <h5>5. Does Setmore send reminders?</h5>
            <p>
              Yes. Setmore sends automatic email confirmations for new or rescheduled appointments, as well as email reminders, and text reminders for users with <a href="https://www.setmore.com/premium" target="_blank">Setmore Premium</a>.
            </p>
          </li>
          <li>
            <h5>6. Does Setmore support payments?</h5>
            <p>
              Yes. Use your Square account with the free version of Setmore, or Upgrade to Setmore Premium to integrate your Stripe account.
            </p>
          </li>
          <li>
            <h5>7. Can I see appointments from my phone?</h5>
            <p>
              Download the Setmore mobile app to access your appointments and book on the go. Search for Setmore in Google Play or the App Store.
            </p>
          </li>
		  <li>
            <h5>8. Does Setmore offer any upgrades?</h5>
            <p>
              Upgrade to Setmore Premium for advanced features like text reminders. Add <a href="https://www.setmore.com/livebooking" target="_blank">Live Booking</a> to any plan for live call answering for your business.
            </p>
          </li>
        </ul>
      </div>
</main>
<?php $scriptUrl = get_bloginfo('wpurl'); ?>
<script id="setmore_script" type="text/javascript" src="<?php echo$scriptUrl ?>/wp-content/plugins/setmore-appointments/script/setmoreFormScript.js"></script>
<?php
}
} ?>
