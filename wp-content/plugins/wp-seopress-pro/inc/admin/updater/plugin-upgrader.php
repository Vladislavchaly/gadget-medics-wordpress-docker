<?php

defined('ABSPATH') or die('Cheatin&#8217; uh?');

///////////////////////////////////////////////////////////////////////////////////////////////////
// Do not delete, unconditionally.
// This is necessary for the execution of the cron
///////////////////////////////////////////////////////////////////////////////////////////////////
include_once plugin_dir_path(__FILE__) . 'migrate-schema.php';
include_once plugin_dir_path(__FILE__) . '../../async/wp-async-migrate-schema.php';
include_once plugin_dir_path(__FILE__) . '../../async/wp-async-clean-old-schema.php';
new WP_SEOPress_Async_Migrate_Schema();
global $background_process_clean_old_schema;
$background_process_clean_old_schema = new WP_SEOPress_Async_Clean_Old_Schema();
///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////

/* --------------------------------------------------------------------------------------------- */
/* MIGRATE / UPGRADE =========================================================================== */
/* --------------------------------------------------------------------------------------------- */

add_action('admin_init', 'seopress_pro_upgrader');
/**
 * Tell WP what to do when admin is loaded aka upgrader.
 *
 * @since 3.8.2
 */
function seopress_pro_upgrader()
{
    $versions = get_option('seopress_versions');
    $actual_version = isset($versions['pro']) ? $versions['pro'] : 0;

    // You can hook the upgrader to trigger any action when seopress is upgraded.
    // First install.
    if (!$actual_version) {
        /*
         * Allow to prevent plugin first install hooks to fire.
         *
         * @since 3.8.2
         *
         * @param (bool) $prevent True to prevent triggering first install hooks. False otherwise.
         */
        if (!apply_filters('seopress_pro_prevent_first_install', false)) {
            /*
             * Fires on the plugin first install.
             *
             * @since 3.8.2
             *
             */
            do_action('seopress_pro_first_install');
        }
    }

    if (SEOPRESS_PRO_VERSION !== $actual_version) {
        /*
         * Fires when seopress Pro is upgraded.
         *
         * @since 3.8.2
         *
         * @param (string) $new_pro_version    The version being upgraded to.
         * @param (string) $actual_pro_version The previous version.
         */
        do_action('seopress_pro_upgrade', SEOPRESS_PRO_VERSION, $actual_version);
    }

    // If any upgrade has been done, we flush and update version.
    if (did_action('seopress_pro_first_install') || did_action('seopress_pro_upgrade')) {
        // Do not use seopress_get_option() here.

        $options = get_option('seopress_versions');
        $options = is_array($options) ? $options : [];

        $options['pro'] = SEOPRESS_PRO_VERSION;

        update_option('seopress_versions', $options);
    }
}

add_action('seopress_pro_upgrade', 'seopress_pro_new_upgrade', 10, 2);
/**
 * What to do when seopress is updated, depending on versions.
 *
 * @since 3.8.2
 *
 * @param (string) $seopress_version The version being upgraded to
 * @param (string) $actual_version   The previous version
 */
function seopress_pro_new_upgrade($seopress_version, $actual_version)
{
    global $wpdb;

    // < 3.8.2
    if (version_compare($actual_version, '3.8.2', '<')) {
        // _seopress_pro_rich_snippets_lb_opening_hours meta_key
        $results = $wpdb->get_results('SELECT post_id, meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key="_seopress_pro_rich_snippets_lb_opening_hours"', ARRAY_A);
        if ($results) {
            foreach ($results as $result) {
                $value = unserialize($result['meta_value']);
                $array_key = false;
                if (isset($value['seopress_pro_rich_snippets_lb_opening_hours'])) {
                    $array_key = 'seopress_pro_rich_snippets_lb_opening_hours';
                } elseif (isset($value['seopress_local_business_opening_hours'])) {
                    $array_key = 'seopress_local_business_opening_hours';
                }
                if (!$array_key) {
                    continue;
                }
                $value = $value[$array_key];
                $value = array_combine(array_reverse(array_keys($value)), array_reverse(array_values($value)));
                $n = 7;
                foreach ($value as $key => $val) {
                    $value[$n--] = $value[$key];
                }
                $value[0] = $value[7];
                unset($value[7]);
                $value = array_combine(array_reverse(array_keys($value)), array_reverse(array_values($value)));
                $value = [$array_key => $value];
                update_post_meta($result['post_id'], '_seopress_pro_rich_snippets_lb_opening_hours', $value);
            }
        }

        // _seopress_pro_schemas meta_key
        $results = $wpdb->get_results('SELECT post_id, meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key="_seopress_pro_schemas"', ARRAY_A);
        if ($results) {
            foreach ($results as $_result) {
                $result = unserialize($_result['meta_value']);
                foreach ($result as $index => $unserialized) {
                    $key = key($unserialized);
                    if (!isset($unserialized['rich_snippets_lb']['opening_hours'])) {
                        continue;
                    }
                    $value = $unserialized['rich_snippets_lb']['opening_hours'];
                    $value = $unserialized['rich_snippets_lb']['opening_hours'];
                    $value = array_combine(array_reverse(array_keys($value)), array_reverse(array_values($value)));
                    $n = 7;
                    foreach ($value as $key => $val) {
                        $value[$n--] = $value[$key];
                    }
                    $value[0] = $value[7];
                    unset($value[7]);
                    $value = array_combine(array_reverse(array_keys($value)), array_reverse(array_values($value)));
                    $result[$index]['rich_snippets_lb']['opening_hours'] = $value;
                }
                update_post_meta($_result['post_id'], '_seopress_pro_schemas', $result);
            }
        }
    }

    // Version 3.9 - migrate schema
    if (version_compare($actual_version, '3.9', '<')) {

        global $background_process_migrate_schema;

		$offset = 0;
		$total = 0;
		$max_int = (int) ini_get('max_input_vars');
		$i = 0;
		do {
			$post_ids = seopress_get_post_ids_need_to_migrate($offset);
			if(!empty($post_ids)){
				$offset += $max_int;
				$total += count($post_ids);
				update_option('_seopress_prepare_batch_' . $i, $post_ids);
			}

			$i++;

		} while (!empty($post_ids));

		if($total == 0){
			return;
		}

		update_option('_seopress_migrate_schema_total', $total);

    }
}
