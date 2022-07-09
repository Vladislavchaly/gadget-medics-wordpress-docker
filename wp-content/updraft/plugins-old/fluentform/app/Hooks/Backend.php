<?php

/**
 * Declare backend actions/filters/shortcodes
 */

/*
 * Regitser All Admin Scripts but don't load it
 */

add_action('admin_init', function () use ($app) {
    (new \FluentForm\App\Modules\Registerer\Menu($app))->reisterScripts();
}, 9);

add_action('admin_enqueue_scripts', function () use ($app) {
    (new \FluentForm\App\Modules\Registerer\Menu($app))->enqueuePageScripts();
}, 10);


// Add Entries Menu
$app->addAction('ff_fluentform_form_application_view_entries', function ($form_id) use ($app) {
    (new \FluentForm\App\Modules\Entries\Entries())->renderEntries($form_id);
});

$app->addAction('fluentform_after_form_navigation', function ($form_id) use ($app) {
    (new \FluentForm\App\Modules\Registerer\Menu($app))->addCopyShortcodeButton($form_id);
    (new \FluentForm\App\Modules\Registerer\Menu($app))->addPreviewButton($form_id);
});

$app->addAction('media_buttons', function () {
    (new \FluentForm\App\Modules\EditorButtonModule())->addButton();
});

$app->addAction('fluentform_addons_page_render_fluentform_add_ons', function () {
    (new \FluentForm\App\Modules\AddOnModule())->showFluentAddOns();
});

// This is temp, we will remove this after 2-3 versions.
add_filter('pre_set_site_transient_update_plugins', function ($updates) {
    if (!empty($updates->response['fluentformpro'])) {
        $updates->response['fluentformpro/fluentformpro.php'] = $updates->response['fluentformpro'];
        unset($updates->response['fluentformpro']);
    }
    return $updates;
}, 999, 1);

$app->addAction('fluentform_global_menu', function () use ($app) {
    $menu = new \FluentForm\App\Modules\Registerer\Menu($app);
    $menu->renderGlobalMenu();
    /*
     * Checking global addon migration
     * This temporary. We will remove this code at 2010
     */
    $activator = new \FluentForm\App\Modules\Activator();
    $activator->migrateGlobalAddOns();

});

$app->addAction('wp_dashboard_setup', function () {
    $roleManager = new \FluentForm\App\Modules\Acl\RoleManager();
    if (!$roleManager->currentUserFormFormCapability()) {
        return;
    }
    wp_add_dashboard_widget('fluenform_stat_widget', __('Fluent Forms Latest Form Submissions', 'fluentform'), function () {
        (new \FluentForm\App\Modules\DashboardWidgetModule)->showStat();
    }, 10, 1);
});

add_action('admin_init', function () {
    $disablePages = [
        'fluent_forms',
        'fluent_forms_transfer',
        'fluent_forms_settings',
        'fluent_form_add_ons',
        'fluent_forms_docs'
    ];
    if (isset($_GET['page']) && in_array($_GET['page'], $disablePages)) {
        remove_all_actions('admin_notices');
    }

    /*
     * We will remove this in upcoming versions
     */
    $activator = new \FluentForm\App\Modules\Activator();
    $activator->maybeMigrateDB();

});

add_action('fluentform_loading_editor_assets', function ($form) {
    add_filter('fluentform_editor_init_element_input_name', function ($field) {
        if (empty($field['settings']['label_placement'])) {
            $field['settings']['label_placement'] = '';
        }
        return $field;
    });
});

add_filter('fluentform_editor_init_element_input_date', function ($item) {
    if (!isset($item['settings']['date_config'])) {
        $item['settings']['date_config'] = '';
    }
    return $item;
});

add_filter('fluentform_editor_init_element_input_number', function ($item) {
    if (!isset($item['settings']['number_step'])) {
        $item['settings']['number_step'] = '';
    }
    return $item;
});

add_action('enqueue_block_editor_assets', function () use ($app) {
    wp_enqueue_script(
        'fluentform-gutenberg-block',
        $app->publicUrl("js/fluent_gutenblock.js"),
        array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor')
    );

    $forms = wpFluent()->table('fluentform_forms')
        ->select(['id', 'title'])
        ->orderBy('id', 'DESC')
        ->get();

    array_unshift($forms, (object)[
        'id'    => '',
        'title' => __('-- Select a form --', 'fluentform')
    ]);

    wp_localize_script('fluentform-gutenberg-block', 'fluentform_block_vars', [
        'logo'  => $app->publicUrl('img/fluent_icon.png'),
        'forms' => $forms
    ]);

    wp_enqueue_style(
        'fluentform-gutenberg-block',
        $app->publicUrl("css/fluent_gutenblock.css"),
        array('wp-edit-blocks')
    );

});


add_action('wp_print_scripts', function () {
    if (is_admin()) {
        if(\FluentForm\App\Helpers\Helper::isFluentAdminPage())
        {
            $option = get_option('_fluentform_global_form_settings');
            $isSkip = \FluentForm\Framework\Helpers\ArrayHelper::get($option, 'misc.noConflictStatus') == 'no';
            $isSkip = apply_filters('fluentform_skip_no_conflict', $isSkip);
            if($isSkip) {
                return;
            }

            global $wp_scripts;
            if(!$wp_scripts) {
                return;
            }

            $pluginUrl = plugins_url();
            foreach ($wp_scripts->queue as $script) {
                $src = $wp_scripts->registered[$script]->src;
                if (strpos($src, $pluginUrl) !== false && !strpos($src, 'fluentform') !== false) {
                    wp_dequeue_script($wp_scripts->registered[$script]->handle);
                }
            }

        }
    }
}, 1);
