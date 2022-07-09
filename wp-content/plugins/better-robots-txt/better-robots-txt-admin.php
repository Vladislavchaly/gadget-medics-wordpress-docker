<?php

class robots_txt_settings
{
    function __construct()
    {
        add_action( 'admin_menu', array( &$this, 'rt_admin_menu' ) );
        function robots_txt_styles()
        {
            wp_register_style(
                'rt-admin-styles',
                plugin_dir_url( __FILE__ ) . 'assets/rt-styles.css',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'assets/rt-styles.css' )
            );
            wp_enqueue_style( 'rt-admin-styles' );
            wp_register_script(
                'rt-admin-script',
                plugin_dir_url( __FILE__ ) . 'assets/rt-script.js',
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . 'assets/rt-script.js' )
            );
            wp_enqueue_script( 'rt-admin-script' );
            wp_register_script( 'rt-admin-script-masonry', plugin_dir_url( __FILE__ ) . 'assets/masonry.min.js' );
            wp_enqueue_script( 'rt-admin-script-masonry' );
        }
        
        add_action( 'admin_enqueue_scripts', 'robots_txt_styles' );
    }
    
    function rt_admin_menu()
    {
        add_menu_page(
            __( 'Better Robots.txt Settings', 'better-robots-txt' ),
            __( 'Better Robots.txt', 'better-robots-txt' ),
            'manage_options',
            'better-robots-txt',
            array( &$this, 'rt_settings_page' ),
            'dashicons-text-page'
        );
    }
    
    // expected robots.txt path
    function robotstxt_path()
    {
        return ABSPATH . 'robots.txt';
    }
    
    // attempt to remove robots.txt physical file
    function remove_robotstxt_file()
    {
        // initialize
        $path = $this->robotstxt_path();
        // check file
        if ( !file_exists( $path ) ) {
            return true;
        }
        // remove file
        @unlink( $path );
        // check if exists
        return !file_exists( $path );
    }
    
    function rt_settings_page()
    {
        global  $robots_txt ;
        $options = $robots_txt->get_options();
        // Safe array
        $rt_safe = array(
            "allow",
            "disallow",
            "remove_settings",
            "boost",
            "robot-faq",
            "robot-recs",
            "growth-tools"
        );
        //Set active class for navigation tabs
        $active_tab = '';
        if ( isset( $_GET['tab'] ) ) {
            $active_tab = sanitize_key( $_GET['tab'] );
        }
        $active_tab = ( isset( $_GET['tab'] ) && in_array( $active_tab, $rt_safe ) ? $active_tab : 'robot-settings' );
        
        if ( isset( $_POST['update'] ) ) {
            // check if user is authorised
            if ( function_exists( 'current_user_can' ) && !current_user_can( 'manage_options' ) ) {
                die( 'Sorry, not allowed...' );
            }
            check_admin_referer( 'robots_txt_settings' );
            global  $agents ;
            // step 1 - user agents isset loop for radio options
            $last = count( $agents ) - 1;
            foreach ( $agents as $i => $row ) {
                $isFirst = $i == 0;
                $isLast = $i == $last;
                $agent_bot = $_POST[$row['bot']];
                $options[$row['bot']] = ( isset( $_POST[$row['bot']] ) && in_array( $agent_bot, $rt_safe ) ? $agent_bot : false );
            }
            //end loop
            // step 1 - chinese search engines
            $chinese_bot = $_POST['chinese_bot'];
            $options['chinese_bot'] = ( isset( $_POST['chinese_bot'] ) && in_array( $chinese_bot, $rt_safe ) ? $chinese_bot : false );
            // end pro only
            // step 2 - spam backlink protector
            $options['feed_protector'] = ( isset( $_POST['feed_protector'] ) && in_array( $_POST['feed_protector'], $rt_safe ) ? $_POST['feed_protector'] : false );
            // step 3 - woocommerce links
            $options['woocom_links'] = ( isset( $_POST['woocom_links'] ) && in_array( $_POST['woocom_links'], $rt_safe ) ? $_POST['woocom_links'] : false );
            // end pro only
            // step 4 - custom rules textarea
            $options['user_agents'] = sanitize_textarea_field( $_POST['user_agents'] );
            // step 4 - crawl delay
            $crawl_delay = sanitize_text_field( $_POST['crawl_delay'] );
            // crawl_delay
            $options['crawl_delay'] = ( isset( $crawl_delay ) && is_numeric( $crawl_delay ) ? $crawl_delay : "" );
            // step 5 - personalize text area
            $options['personalize'] = sanitize_textarea_field( $_POST['personalize'] );
            // step 5 - corona message
            $options['covid-19'] = ( isset( $_POST['covid-19'] ) && in_array( $_POST['covid-19'], $rt_safe ) ? $_POST['covid-19'] : false );
            // step 6 - crawl budget issues
            $options['crawl_budget'] = ( isset( $_POST['crawl_budget'] ) && in_array( $_POST['crawl_budget'], $rt_safe ) ? $_POST['crawl_budget'] : false );
            // step 7 - ask for backlinks
            $options['ask-backlinks'] = ( isset( $_POST['ask-backlinks'] ) && in_array( $_POST['ask-backlinks'], $rt_safe ) ? $_POST['ask-backlinks'] : false );
            // step 8 - boost alt notice
            $options['boost-alt'] = ( isset( $_POST['boost-alt'] ) && in_array( $_POST['boost-alt'], $rt_safe ) ? $_POST['boost-alt'] : false );
            // step 8 - mobilook
            $options['rt-mobilook'] = ( isset( $_POST['rt-mobilook'] ) && in_array( $_POST['rt-mobilook'], $rt_safe ) ? $_POST['rt-mobilook'] : false );
            // step 8 - bigta
            $options['rt-bigta'] = ( isset( $_POST['rt-bigta'] ) && in_array( $_POST['rt-bigta'], $rt_safe ) ? $_POST['rt-bigta'] : false );
            // step 8 - vidseo
            $options['rt-vidseo'] = ( isset( $_POST['rt-vidseo'] ) && in_array( $_POST['rt-vidseo'], $rt_safe ) ? $_POST['rt-vidseo'] : false );
            // step 10 - ads.txt and app-ads.txt
            $ads_txt = sanitize_text_field( $_POST['ads-txt'] );
            $options['ads-txt'] = ( isset( $_POST['ads-txt'] ) && in_array( $ads_txt, $rt_safe ) ? $ads_txt : false );
            $app_ads_txt = sanitize_text_field( $_POST['app-ads-txt'] );
            $options['app-ads-txt'] = ( isset( $_POST['app-ads-txt'] ) && in_array( $app_ads_txt, $rt_safe ) ? $app_ads_txt : false );
            // end pro only
            // remove settings on plugin deactivation
            $options['remove_settings'] = ( isset( $_POST['remove_settings'] ) && in_array( $_POST['remove_settings'], $rt_safe ) ? $_POST['remove_settings'] : false );
            $rt_success = true;
            if ( isset( $rt_success ) ) {
                echo  '<div class="notice notice-success is-dismissible"><p><strong>' . __( 'Settings saved', 'better-robots-txt' ) . '</strong></p></div> ' ;
            }
            if ( !$this->remove_robotstxt_file() ) {
                echo  rt_notices::robots_file_not_deleted() ;
            }
            update_option( 'robots_txt', $options );
            // update options
        }
        
        // end if
        // show notification if robots file exists
        if ( file_exists( $this->robotstxt_path() ) ) {
            rt_notices::robots_file_exists();
        }
        // purchase notification
        $purchase_url = "options-general.php?page=better-robots-txt-pricing";
        $get_pro = sprintf( wp_kses( __( '<a href="%s">Get Pro version</a> to enable', 'better-robots-txt' ), array(
            'a' => array(
            'href'   => array(),
            'target' => array(),
        ),
        ) ), esc_url( $purchase_url ) );
        ?>
			
		<div class="wrap robot-txt">
			
            <h2><span class="dashicons dashicons-media-text" style="margin-top: 6px; font-size: 24px;"></span> Better Robots.txt
                <?php 
        //end pro only
        echo  __( 'Settings                                                                                                                             ', 'better-robots-txt' ) ;
        ?>
                (Index & Rank Booster by Pagup)</h2>
            
			<h2 class="nav-tab-wrapper">
                    <a href="?page=better-robots-txt&tab=robot-settings" class="nav-tab <?php 
        echo  ( $active_tab == 'robot-settings' ? 'nav-tab-active' : '' ) ;
        ?>">Settings</a>
                    <a href="?page=better-robots-txt&tab=robot-faq" class="nav-tab <?php 
        echo  ( $active_tab == 'robot-faq' ? 'nav-tab-active' : '' ) ;
        ?>">FAQ</a>
					<a href="?page=better-robots-txt&tab=robot-recs" class="nav-tab <?php 
        echo  ( $active_tab == 'robot-recs' ? 'nav-tab-active' : '' ) ;
        ?>">Plugin Recommendations</a>
					<a href="?page=better-robots-txt&tab=growth-tools" class="nav-tab <?php 
        echo  ( $active_tab == 'growth-tools' ? 'nav-tab-active' : '' ) ;
        ?>">150+ Growth Hacking Tools</a>
				
            </h2>
			
			<?php 
        
        if ( $active_tab == 'robot-settings' ) {
            ?>
		
		<!-- start main settings column -->
		<div class="rt-row">
		<div class="rt-column col-8">
		<div class="rt-main">

		<form method="post">
		
		<?php 
            if ( function_exists( 'wp_nonce_field' ) ) {
                wp_nonce_field( 'robots_txt_settings' );
            }
            //free only
            // Pro recommendation
            echo  rt_notices::pro_recommendation() ;
            // Check your robots.txt notice
            echo  rt_notices::check_robotstxt() ;
            // Include all ui files
            $file_names = array(
                'step-1',
                'step-2',
                'step-3',
                'step-4',
                'step-5',
                'step-6',
                'step-7',
                'step-8',
                'step-9',
                'step-10',
                'wp-multisite',
                'delete'
            );
            foreach ( $file_names as $name ) {
                include_once dirname( __FILE__ ) . '/admin-ui-inc/' . $name . '.php';
            }
            ?>

	<?php 
            //echo "<div display='none'><script type='text/javascript'>console.log('Output: ".$options['remove_settings']."')</script></div>";
            ?>
		
	<p class="submit"><input type="submit" name="update" class="button-primary" value="Save Changes" /></p>
	</form>
            
	<?php 
            // Metabox notice
            echo  rt_notices::metabox_robotstxt() ;
            // Set Permalinks, Clear Cache after Saving Changes notice
            echo  rt_notices::clear_notice() ;
            // SEO tools recommendations
            include dirname( __FILE__ ) . '/inc/seo-recommendations.php';
            ?> 

	</div> <!-- end rt-main -->	
	</div> <!-- end main settings rt-column col-8 -->
			
	<?php 
            include dirname( __FILE__ ) . '/inc/sidebar.php';
        }
        
        if ( $active_tab == 'robot-faq' ) {
            include dirname( __FILE__ ) . '/inc/faq.php';
        }
        if ( $active_tab == 'robot-recs' ) {
            include dirname( __FILE__ ) . '/inc/recommendations.php';
        }
        if ( $active_tab == 'growth-tools' ) {
            include dirname( __FILE__ ) . '/inc/growth-tools.php';
        }
        ?>
			
	</div>
			
	<?php 
    }

}
// end class
$robots_txt_settings = new robots_txt_settings();