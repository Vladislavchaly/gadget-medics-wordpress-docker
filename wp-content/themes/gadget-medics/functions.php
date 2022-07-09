<?php


//custom load more
function blog_scripts() {
    // Register the script
    wp_register_script( 'custom-script', get_stylesheet_directory_uri(). '/js/custom-load-more.js', array('jquery'), false, true );

    // Localize the script with new data
    $script_data_array = array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'security' => wp_create_nonce( 'load_more_posts' ),
    );
    wp_localize_script( 'custom-script', 'blog', $script_data_array );

    // Enqueued script with localized data.
    wp_enqueue_script( 'custom-script' );
    //slick
    wp_enqueue_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css');
    wp_enqueue_style( 'slick-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css' );
    wp_enqueue_script( 'slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js', array(), '', true );
//    wp_enqueue_script( 'skick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'blog_scripts' );
add_theme_support( 'title-tag' );

add_action('wp_ajax_load_marketplaces_by_ajax', 'load_marketplaces_by_ajax_callback');
add_action('wp_ajax_nopriv_load_marketplaces_by_ajax', 'load_marketplaces_by_ajax_callback');


function load_marketplaces_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'post',
        'category_name' => 'Smartphones Marketplace',
        'posts_per_page' => '3',
        'paged' => $paged,
    );
    $blog_posts = new WP_Query( $args );
    ?>

    <?php if ($blog_posts->have_posts()) : ?>
        <?php while ($blog_posts->have_posts()): $blog_posts->the_post(); ?>
            <?php $post_id = get_the_ID();
            $categories = get_the_category($post_id);
            $price = get_field('price');

            $memory = get_field('memory');
            $color = get_field('color');
            $condition = get_field('condition');
            $carrier = get_field('carrier');
            $type = get_field('type');
            $series = get_field('series');
            $screen = get_field('screen');
            ?>
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id )); ?>
            <div class="products-block__item">
                <div  class="products-block__link">
                                        <span class="products-block__img" style="position: relative">
                                            <p class="price-cst">$<?php echo $price?></p>
                                            <img src="<?php echo $image[0] ?>" alt="">
                                        </span>
                    <div class="products-block__txt">
                                        <span class="product-cat-name">
                                            <?php echo  $categories[0]->name ?>
                                        </span>
                        <span class="h4"><?php the_title();?></span>
                        <?php if($memory) {?>
                            <div class="tes">
                                <ul class="colors-list">
                                    <li><?php echo '   '.$memory ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Memory</p>
                            </div>
                        <?php }?>
                        <?php if($color) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$color ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Color</p>
                            </div>
                        <?php }?>
                        <?php if($condition) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$condition ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Condition</p>
                            </div>
                        <?php }?>
                        <?php if($series) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$series ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Series</p>
                            </div>
                        <?php }?>
                        <?php if($type) {?>
                            <div class="tes">
                                <ul class="colors-list">
                                    <li><?php echo '   '.$type ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Type</p>
                            </div>
                        <?php }?>
                        <?php if($screen) {?>
                            <div class="tes" >
                                <ul class="colors-list">
                                    <li><?php echo '   '.$screen ?></li>
                                </ul>
                                <span class="brd"></span>
                                <p>Screen</p>
                            </div>
                        <?php }?>
                        <a href="#" class="btn btn-outline btn-outline-primary cst-modal" style="margin-top: 20px">
                            <b>Reserve for in-store pickup</b>
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif;

    wp_die();
}



//news load more
add_action('wp_ajax_load_news_by_ajax', 'load_news_by_ajax_callback');
add_action('wp_ajax_nopriv_load_news_by_ajax', 'load_news_by_ajax_callback');


function load_news_by_ajax_callback() {
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'post',
        'category_name' => 'Digital News',
        'posts_per_page' => '3',
        'paged' => $paged,
    );
    $news_posts = new WP_Query( $args );
    if ($news_posts->have_posts()) : ?>
    <?php while ($news_posts->have_posts()): $news_posts->the_post(); ?>
        <?php $post_id = get_the_ID();?>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id )); ?>
        <div class="news-block__item" style="width: 33%;">
            <a href="#" class="news-block__link">
                                        <span class="news-block__img">
                                            <img src="<?php echo $image[0]?>" alt="">
                                        </span>
                <div class="news-block__txt">
                    <!--                                        <small>Tag name</small>-->
                    <span class="h4"><?php the_title()?></span>
                    <!--                                        <p>--><?php //the_content()?><!--</p>-->
                </div>
            </a>
        </div>
    <?php endwhile; ?>
    <?php endif; ?>
<?php
    wp_die();
}



if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}
add_theme_support('menus');
add_theme_support('widgets');
add_theme_support('post-thumbnails');

define("THEME_DIR", get_template_directory_uri());
//add_image_size( 'custom-size', 220, 220, array( 'center', 'center' ) );
//the_post_thumbnail('thumbnail');       // Thumbnail (default 150px x 150px max)
//the_post_thumbnail('medium');          // Medium resolution (default 300px x 300px max)
//the_post_thumbnail('medium_large');    // Medium Large resolution (default 768px x 0px max)
//the_post_thumbnail('large');           // Large resolution (default 1024px x 1024px max)
//the_post_thumbnail('full');            // Original image resolution (unmodified)
// clean head
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'xyz_remove_admin_bar_css', 21);
    add_action('admin_enqueue_scripts', 'xyz_remove_admin_bar_css', 21);
    function xyz_remove_admin_bar_css()
    {
        wp_dequeue_style('admin-bar');
        wp_dequeue_style('admin-bar-min');
    }
}
// svg
// define('ALLOW_UNFILTERED_UPLOADS', true);
function add_file_types_to_uploads($file_types)
{
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}

add_action('upload_mimes', 'add_file_types_to_uploads');

/*** Удаление мусора в head ***/

remove_action('wp_head', 'feed_links_extra', 3); // убирает ссылки на rss категорий
remove_action('wp_head', 'feed_links', 2); // минус ссылки на основной rss и комментарии
remove_action('wp_head', 'rsd_link');  // сервис Really Simple Discovery
remove_action('wp_head', 'wlwmanifest_link'); // Windows Live Writer
remove_action('wp_head', 'wp_generator');  // скрыть версию wordpress

remove_action('wp_head', 'start_post_rel_link', 10);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11);

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


add_filter('the_generator', '__return_empty_string'); // Убираем версию WordPress
remove_action('wp_head', 'wp_resource_hints', 2); // Prints resource hints to browsers for pre-fetching, pre-rendering and pre-connecting to web sites.
remove_action('wp_head', 'locale_stylesheet');
add_filter('show_admin_bar', '__return_false');

/*** /Удаление мусора в head ***/

/*** Удаление мусора в админке ***/

function remove_dashboard_meta()
{
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');

    remove_meta_box('appscreo_news', 'dashboard', 'normal');
}

add_action('admin_init', 'remove_dashboard_meta');

function remove_admin_bar_links()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');

/*** /Удаление мусора в админке ***/


//cf 7
// define('WPCF7_AUTOP', false );
// acceptance_as_validation: on
add_action('wp_enqueue_scripts', 'true_otkljuchaem_stili_contact_form'); // по идее вы можете использовать и хук wp_enqueue_scripts, хотя конкретно его я не тестировал
function true_otkljuchaem_stili_contact_form()
{
    wp_deregister_style('contact-form-7'); // в параметрах - ID подключаемого файла
}

// Заменям надпись в админке "Спасибо вам за творчество с WordPress" на свою
function remove_footer_admin()
{
    echo '<span id="footer-thankyou">Developed by <a href="mailto:codehunt.web@gmail.com"><b>Codehunt</b></a></span>';
}

add_action('after_setup_theme', 'theme_register_nav_menu');
function theme_register_nav_menu()
{
    register_nav_menu('primary', 'Primary Menu');
    register_nav_menu('repair', 'Menu repair');
}

add_filter('admin_footer_text', 'remove_footer_admin');
function site_scripts()
{
//    wp_enqueue_style( 'site-font2', 'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Roboto+Condensed:300,300i,400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext' );
//    wp_enqueue_style( 'site-swiper', THEME_DIR .  '/css/swiper.css' );
//    wp_enqueue_style( 'site-fancybox', THEME_DIR .  '/css/jquery.fancybox.css' );
    wp_enqueue_style('site-style', THEME_DIR . '/css/style.css');
    wp_enqueue_style('site-style2', THEME_DIR . '/style.css');
}

add_action('wp_enqueue_scripts', 'site_scripts');

add_action('wp_enqueue_scripts', 'myajax_data', 99);
function myajax_data()
{

    wp_localize_script('jquery-vendor', 'myajax',
        array(
            'url' => admin_url('admin-ajax.php')
        )
    );

}

function my_scripts_method()
{
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', false, null, false);
    wp_enqueue_script('jquery-fancybox', THEME_DIR . '/js/jquery.fancybox.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-swiper', THEME_DIR . '/js/swiper.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-wow', THEME_DIR . '/js/wow.min.js', array('jquery'), null, true);
    wp_enqueue_script('jquery-main', THEME_DIR . '/js/main.js', array('jquery'), null, true);
    if ( is_page( 760 ) ) {
            wp_enqueue_style('form-page-styles', THEME_DIR . '/css/styles.css');
            wp_dequeue_style('site-style');
            wp_dequeue_style('site-style2');
            wp_enqueue_script('form-page', THEME_DIR . '/js/scripts.js', array('jquery'), null, true);
            wp_enqueue_script('changeSelectColor', THEME_DIR . '/js/changeSelectColor.js', array('jquery'), null, true);
        }
}

add_action('wp_enqueue_scripts', 'my_scripts_method', 11);
//all in footer
//function footer_enqueue_scripts(){
//    remove_action('wp_head','wp_print_scripts');
//    remove_action('wp_head','wp_print_head_scripts',9);
//    remove_action('wp_head','wp_enqueue_scripts',1);
//    add_action('wp_footer','wp_print_scripts',5);
//    add_action('wp_footer','wp_enqueue_scripts',5);
//    add_action('wp_footer','wp_print_head_scripts',5);
//}
//add_action('after_setup_theme','footer_enqueue_scripts');
add_filter('navigation_markup_template', 'my_navigation_template', 10, 2);
function my_navigation_template($template, $class)
{
    return '<div class="pagination">%3$s</div>';
}

//  чистим админ меню
//function remove_menus()
//{
//    remove_menu_page('index.php');                  //Консоль
//    //remove_menu_page( 'edit.php' );                   //Записи
//    remove_menu_page('upload.php');                 //Медиафайлы
//    //remove_menu_page( 'edit.php?post_type=page' );    //Страницы
//    remove_menu_page('edit-comments.php');          //Комментарии
//    //remove_menu_page( 'themes.php' );                 //Внешний вид
//    //remove_menu_page( 'plugins.php' );                //Плагины
//    remove_menu_page('users.php');                  //Пользователи
//    remove_menu_page('tools.php');                  //Инструменты
//    //remove_menu_page( 'options-general.php' );        //Настройки
//}
//
//add_action('admin_menu', 'remove_menus');


function appthemes_add_quicktags()
{
    if (wp_script_is('quicktags')) {
        ?>
        <script type="text/javascript">
            QTags.addButton('eg_paragraph', 'p', '<p>', '</p>', 'p', 'Параграф', 1);
            QTags.addButton('eg_h2', 'h2', '<h2>', '</h2>', 'h', 'Заголовок h2', 30);
            QTags.addButton('eg_h3', 'h3', '<h3>', '</h3>', 'h', 'Заголовок h3', 31);
            QTags.addButton('eg_hr', 'hr', '<hr />', '', 'r', 'Горизонтальная линия', 32);
            QTags.addButton('eg_br', 'br', '<br>', '', 'r', 'Перенос строки', 33);
            QTags.addButton('eg_span', 'span', '<span>', '</span>', 's', 'Подзаголовок', 34);
        </script>
        <?php
    }
}

add_action('admin_print_footer_scripts', 'appthemes_add_quicktags');
add_filter('get_the_archive_title', 'artabr_remove_name_cat');
function artabr_remove_name_cat($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    } elseif (is_tax('category-products')) {
        $title = single_tag_title('', false);
    }
    return $title;
}

// удалить атрибут type у scripts и styles
add_filter('style_loader_tag', 'clean_style_tag');
function clean_style_tag($src)
{
    return str_replace("type='text/css'", '', $src);
}

add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($src)
{
    return str_replace("type='text/javascript'", '', $src);
}


add_filter('plugin_action_links', 'disable_plugin_deactivation', 10, 2);
function disable_plugin_deactivation($actions, $plugin_file)
{
    // Удаляет действие "Редактировать" у всех плагинов
    unset($actions['edit']);

    // Удаляет действие "Деактивировать" у важных для сайта плагинов
    $important_plugins = array(
        'advanced-custom-fields-pro/acf.php',
        'contact-form-7/wp-contact-form-7.php',
    );
    if (in_array($plugin_file, $important_plugins)) {
        unset($actions['deactivate']);
        $actions['info'] = '<b class="musthave_js">Обязателен для сайта</b>';
    }

    return $actions;
}

// удаляем груповые действия: деактивировать и удалить
add_filter('admin_print_footer_scripts-plugins.php', 'disable_plugin_deactivation_hide_checkbox');
function disable_plugin_deactivation_hide_checkbox($actions)
{
    ?>
    <script>
        jQuery(function ($) {
            $('.musthave_js').closest('tr').find('input[type="checkbox"]').remove();
        });
    </script>
    <?php
}

/*** Запрет обновления выборочных плагинов ***/

function filter_plugin_updates($update)
{
    global $DISABLE_UPDATE; // см. wp-config.php
    if (!is_array($DISABLE_UPDATE) || count($DISABLE_UPDATE) == 0) {
        return $update;
    }
    foreach ($update->response as $name => $val) {
        foreach ($DISABLE_UPDATE as $plugin) {
            if (stripos($name, $plugin) !== false) {
                unset($update->response[$name]);
            }
        }
    }
    return $update;
}

add_filter('site_transient_update_plugins', 'filter_plugin_updates');

$DISABLE_UPDATE = array('acf');

/*** /Запрет обновления выборочных плагинов ***/

function check_value($value)
{
    if (empty($value)) {
        return 'Не указан';
    } else {
        return $value;
    }
}

add_filter('style_loader_tag', 'codeless_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'codeless_remove_type_attr', 10, 2);
function codeless_remove_type_attr($tag, $handle)
{
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}

function add_option_field_to_general_admin_page()
{
    $option_name_clode = 'close_status_option';
    $option_name_open = 'open_status_option';
    $option_name_clodenew = 'closenew_status_option';
    $option_name_opennew = 'opennew_status_option';
//    $option_name_checkbox = 'checkbox_status_option';
    //Weekday
    $monday_name = 'monday_status_option';
    $mondayend_name = 'mondayend_status_option';
    $tuesday_name = 'tuesday_status_option';
    $tuesdayend_name = 'tuesdayend_status_option';
    $wednesday_name = 'wednesday_status_option';
    $wednesdayend_name = 'wednesdayend_status_option';
    $thursday_name = 'thursday_status_option';
    $thursdayend_name = 'thursdayend_status_option';
    $fridays_name = 'fridays_status_option';
    $fridaysend_name = 'fridaysend_status_option';
    $saturday_name = 'saturday_status_option';
    $saturdayend_name = 'saturdayend_status_option';
    $sunday_name = 'sunday_status_option';
    $sundayend_name = 'sundayend_status_option';
    // регистрируем опцию
    register_setting('general', $option_name_clode);

    // добавляем поле
    add_settings_field(
        'myprefix_setting-id',
        'Статус магазина закрыт',
        'myprefix_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'myprefix_setting-id',
            'option_name' => 'close_status_option'
        )
    );
    // регистрируем опцию
    register_setting('general', $option_name_open);

    // добавляем поле
    add_settings_field(
        'open_setting-id',
        'Статус магазина открыт',
        'open_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'open_setting-id',
            'option_name' => 'open_status_option'
        )
    );
//    // регистрируем опцию
//    register_setting('general', $option_name_clodenew);
//
//    // добавляем поле
//    add_settings_field(
//        'myprefixnew_setting-id',
//        'Статус магазина закрыт Новый',
//        'myprefixnew_setting_callback_function',
//        'general',
//        'default',
//        array(
//            'id' => 'myprefixnew_setting-id',
//            'option_name' => 'closenew_status_option'
//        )
//    );
//    // регистрируем опцию
//    register_setting('general', $option_name_opennew);
//
//    // добавляем поле
//    add_settings_field(
//        'opennew_setting-id',
//        'Статус магазина открыт Новый',
//        'opennew_setting_callback_function',
//        'general',
//        'default',
//        array(
//            'id' => 'opennew_setting-id',
//            'option_name' => 'opennew_status_option'
//        )
//    );
//    register_setting('general', $option_name_checkbox);
//
//    // добавляем поле
//    add_settings_field(
//        'checkbox_setting-id',
//        'Выберете дни к которым будет применяться новый статус',
//        'checkbox_setting_callback_function',
//        'general',
//        'default',
//        array(
//            'id' => 'checkbox_setting-id',
//            'option_name' => 'checkbox_status_option'
//        )
//
//    );
    // регистрируем опцию
    register_setting('general', $monday_name);

    // добавляем поле
    add_settings_field(
        'monday_setting-id',
        'Понедельник время открытия',
        'monday_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'monday_setting-id',
            'option_name' => 'monday_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $mondayend_name);

    // добавляем поле
    add_settings_field(
        'mondayend_setting-id',
        'Понедельник время закрытия',
        'mondayend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'mondayend_setting-id',
            'option_name' => 'mondayend_status_option'
        )
    );
    // регистрируем опцию
    register_setting('general', $tuesday_name);

    // добавляем поле
    add_settings_field(
        'tuesday_setting-id',
        'Втр время открытия',
        'tuesday_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'tuesday_setting-id',
            'option_name' => 'tuesday_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $tuesdayend_name);

    // добавляем поле
    add_settings_field(
        'tuesdayend_setting-id',
        'Втр время закрытия',
        'tuesdayend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'tuesdayend_setting-id',
            'option_name' => 'tuesdayend_status_option'
        )
    );

// регистрируем опцию
    register_setting('general', $wednesday_name);

    // добавляем поле
    add_settings_field(
        'wednesday_setting-id',
        'Срд время открытия',
        'wednesday_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'wednesday_setting-id',
            'option_name' => 'wednesday_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $wednesdayend_name);

    // добавляем поле
    add_settings_field(
        'wednesdayend_setting-id',
        'Срд время закрытия',
        'wednesdayend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'wednesdayend_setting-id',
            'option_name' => 'wednesdayend_status_option'
        )
    );
    register_setting('general', $thursday_name);

    // добавляем поле
    add_settings_field(
        'thursday_setting-id',
        'Чт время открытия',
        'thursday_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'thursday_setting-id',
            'option_name' => 'thursday_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $thursdayend_name);

    // добавляем поле
    add_settings_field(
        'thursdayend_setting-id',
        'Чт время закрытия',
        'thursdayend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'thursdayend_setting-id',
            'option_name' => 'thursdayend_status_option'
        )
    );
    // регистрируем опцию
    register_setting('general', $fridays_name);

    // добавляем поле
    add_settings_field(
        'fridays_setting-id',
        'Пт время открытия',
        'fridays_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'fridays_setting-id',
            'option_name' => 'fridays_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $fridaysend_name);

    // добавляем поле
    add_settings_field(
        'fridaysend_setting-id',
        'Пт время закрытия',
        'fridaysend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'fridaysend_setting-id',
            'option_name' => 'fridaysend_status_option'
        )
    );
    // регистрируем опцию
    register_setting('general', $saturday_name);

    // добавляем поле
    add_settings_field(
        'saturday_setting-id',
        'Сб время открытия',
        'saturday_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'saturday_setting-id',
            'option_name' => 'saturday_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $saturdayend_name);

    // добавляем поле
    add_settings_field(
        'saturdayend_setting-id',
        'Сб время закрытия',
        'saturdayend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'saturdayend_setting-id',
            'option_name' => 'saturdayend_status_option'
        )
    );
    // регистрируем опцию
    register_setting('general', $sunday_name);

    // добавляем поле
    add_settings_field(
        'sunday_setting-id',
        'Вск время открытия',
        'sunday_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'sunday_setting-id',
            'option_name' => 'sunday_status_option'
        )
    );


    // регистрируем опцию
    register_setting('general', $sundayend_name);

    // добавляем поле
    add_settings_field(
        'sundayend_setting-id',
        'Вск время закрытия',
        'sundayend_setting_callback_function',
        'general',
        'default',
        array(
            'id' => 'sundayend_setting-id',
            'option_name' => 'sundayend_status_option'
        )
    );
}

add_action('admin_menu', 'add_option_field_to_general_admin_page');

function myprefix_setting_callback_function($val)
{
    $id = $val['id'];
    $option_name_clode = $val['option_name'];
    ?>
    <input
            type="text"
            name="<? echo $option_name_clode ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($option_name_clode)) ?>"
    />
    <?
}

function open_setting_callback_function($val)
{
    $id = $val['id'];
    $option_name_open = $val['option_name'];
    ?>
    <input
            type="text"
            name="<? echo $option_name_open ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($option_name_open)) ?>"
    />
    <?
}


function monday_setting_callback_function($val)
{
    $id = $val['id'];
    $monday_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $monday_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($monday_name)) ?>"
    />
    <?
}

function mondayend_setting_callback_function($val)
{
    $id = $val['id'];
    $mondayend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $mondayend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($mondayend_name)) ?>"
    />
    <?
}

function tuesday_setting_callback_function($val)
{
    $id = $val['id'];
    $tuesday_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $tuesday_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($tuesday_name)) ?>"
    />
    <?
}

function tuesdayend_setting_callback_function($val)
{
    $id = $val['id'];
    $tuesdayend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $tuesdayend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($tuesdayend_name)) ?>"
    />
    <?
}

function wednesday_setting_callback_function($val)
{
    $id = $val['id'];
    $wednesday_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $wednesday_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($wednesday_name)) ?>"
    />
    <?
}

function wednesdayend_setting_callback_function($val)
{
    $id = $val['id'];
    $wednesdayend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $wednesdayend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($wednesdayend_name)) ?>"
    />
    <?
}


function thursday_setting_callback_function($val)
{
    $id = $val['id'];
    $thursday_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $thursday_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($thursday_name)) ?>"
    />
    <?
}

function thursdayend_setting_callback_function($val)
{
    $id = $val['id'];
    $thursdayend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $thursdayend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($thursdayend_name)) ?>"
    />
    <?
}

function fridays_setting_callback_function($val)
{
    $id = $val['id'];
    $fridays_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $fridays_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($fridays_name)) ?>"
    />
    <?
}

function fridaysend_setting_callback_function($val)
{
    $id = $val['id'];
    $fridaysend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $fridaysend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($fridaysend_name)) ?>"
    />
    <?
}


function saturday_setting_callback_function($val)
{
    $id = $val['id'];
    $saturday_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $saturday_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($saturday_name)) ?>"
    />
    <?
}

function saturdayend_setting_callback_function($val)
{
    $id = $val['id'];
    $saturdayend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $saturdayend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($saturdayend_name)) ?>"
    />
    <?
}


function sunday_setting_callback_function($val)
{
    $id = $val['id'];
    $sunday_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $sunday_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($sunday_name)) ?>"
    />
    <?
}

function sundayend_setting_callback_function($val)
{
    $id = $val['id'];
    $sundayend_name = $val['option_name'];
    ?>
    <input
            type="time"
            name="<? echo $sundayend_name ?>"
            id="<? echo $id ?>"
            value="<? echo esc_attr(get_option($sundayend_name)) ?>"
    />
    <?
}


///////////////////

// ------------------------------------------------------------------
// Вешаем все блоки, поля и опции на хук admin_init
// ------------------------------------------------------------------
//
add_action( 'admin_init', 'eg_settings_api_init' );
function eg_settings_api_init() {
    // Добавляем блок опций на базовую страницу "Чтение"
    add_settings_section(
        'eg_setting_section', // секция
        'Настройка статуса магазина для определенных дней недели',
        'eg_setting_section_callback_function',
        'general' // страница
    );

    // Добавляем поля опций. Указываем название, описание,
    // функцию выводящую html код поля опции.
    add_settings_field(
        'eg_setting_name_open',
        'Статус магазина Открыт',
        'eg_setting_callback_function', // можно указать ''
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name_close',
        'Статус магазина Закрыт',
        'eg_setting_callback_function1', // можно указать ''
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name2',
        'Понедельник',
        'eg_setting_callback_function2',
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name3',
        'Вторник',
        'eg_setting_callback_function3',
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name4',
        'Среда',
        'eg_setting_callback_function4',
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name5',
        'Четверг',
        'eg_setting_callback_function5',
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name6',
        'Пятница',
        'eg_setting_callback_function6',
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name7',
        'Суббота',
        'eg_setting_callback_function7',
        'general', // страница
        'eg_setting_section' // секция
    );
    add_settings_field(
        'eg_setting_name8',
        'Воскресенье',
        'eg_setting_callback_function8',
        'general', // страница
        'eg_setting_section' // секция
    );

    // Регистрируем опции, чтобы они сохранялись при отправке
    // $_POST параметров и чтобы callback функции опций выводили их значение.
    register_setting( 'general', 'eg_setting_name_open' );
    register_setting( 'general', 'eg_setting_name_close' );
    register_setting( 'general', 'eg_setting_name2' );
    register_setting( 'general', 'eg_setting_name3' );
    register_setting( 'general', 'eg_setting_name4' );
    register_setting( 'general', 'eg_setting_name5' );
    register_setting( 'general', 'eg_setting_name6' );
    register_setting( 'general', 'eg_setting_name7' );
    register_setting( 'general', 'eg_setting_name8' );
}

// ------------------------------------------------------------------
// Сallback функция для секции
// ------------------------------------------------------------------
//
// Функция срабатывает в начале секции, если не нужно выводить
// никакой текст или делать что-то еще до того как выводить опции,
// то функцию можно не использовать для этого укажите '' в третьем
// параметре add_settings_section
//
function eg_setting_section_callback_function() {
    echo '<p>Заполните новый статус магазина и отметьте дни недели для которых должен примениться данный статус</p>';
}

// ------------------------------------------------------------------
// Callback функции выводящие HTML код опций
// ------------------------------------------------------------------
//
// Создаем checkbox и text input теги
//
function eg_setting_callback_function() {
    echo '<input 
		name="eg_setting_name_open"  
		type="text" 
		value="' . get_option( 'eg_setting_name_open' ) . '" 
		class="code2"
	 />';
}
function eg_setting_callback_function1() {
    echo '<input 
		name="eg_setting_name_close"  
		type="text" 
		value="' . get_option( 'eg_setting_name_close' ) . '" 
		class="code2"
	 />';
}
//function eg_setting_callback_function1() {
//    echo '<input
//		name="eg_setting_name_close"
//		type="checkbox"
//		' . checked( 1, get_option( 'eg_setting_name_close' ), false ) . '
//		value="1"
//		class="code"
//	/>';
//}
function eg_setting_callback_function2() {
    echo '<input 
		name="eg_setting_name2" 
		type="checkbox" 
		' . checked( "Mon", get_option( 'eg_setting_name2' ), false ) . ' 
		value="Mon" 
		class="code" 
	/>';
}
function eg_setting_callback_function3() {
    echo '<input 
		name="eg_setting_name3" 
		type="checkbox" 
		' . checked( "Tue", get_option( 'eg_setting_name3' ), false ) . ' 
		value="Tue" 
		class="code" 
	/>';
}
function eg_setting_callback_function4() {
    echo '<input 
		name="eg_setting_name4" 
		type="checkbox" 
		' . checked( "Wed", get_option( 'eg_setting_name4' ), false ) . ' 
		value="Wed" 
		class="code" 
	/>';
}
function eg_setting_callback_function5() {
    echo '<input 
		name="eg_setting_name5" 
		type="checkbox" 
		' . checked( "Thu", get_option( 'eg_setting_name5' ), false ) . ' 
		value="Thu" 
		class="code" 
	/>';
}
function eg_setting_callback_function6() {
    echo '<input 
		name="eg_setting_name6" 
		type="checkbox" 
		' . checked( "Fri", get_option( 'eg_setting_name6' ), false ) . ' 
		value="Fri" 
		class="code" 
	/>';
}
function eg_setting_callback_function7() {
    echo '<input 
		name="eg_setting_name7" 
		type="checkbox" 
		' . checked( "Sat", get_option( 'eg_setting_name7' ), false ) . ' 
		value="Sat" 
		class="code" 
	/>';
}
function eg_setting_callback_function8() {
    echo '<input 
		name="eg_setting_name8" 
		type="checkbox" 
		' . checked( "Sun", get_option( 'eg_setting_name8' ), false ) . ' 
		value="Sun" 
		class="code" 
	/>';
}




add_action('wp_ajax_nopriv_filter', 'filter');
add_action('wp_ajax_filter', 'filter');
function filter(){
    $args = array(); // подготовим массив
    $args['numberposts'] = -1;
    $args['cat'] = ''.$_POST['term_id'].'';

    $wp_query = new WP_Query( $args );
    if (  $wp_query->have_posts() ) { ?>
        <?php while ($wp_query->have_posts()) : $wp_query->the_post();
            get_template_part('template/content-news');
        endwhile;?>
    <?php }
    wp_reset_postdata();
    die();
}
function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );
     
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

