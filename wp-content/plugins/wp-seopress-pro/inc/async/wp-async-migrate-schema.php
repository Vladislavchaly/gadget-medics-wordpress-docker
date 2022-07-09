<?php

defined('ABSPATH') or die('Please don&rsquo;t call the plugin directly. Thanks :)');

class WP_SEOPress_Async_Migrate_Schema extends WP_SEOPress_Background_Process
{
	/**
	 * @var string
	 */
	protected $action = 'seopress_migrate_schema';


	protected function task($post_id)
	{
		include_once plugin_dir_path(__FILE__) . '../admin/updater/migrate-schema.php';
		$counter = get_option('_seopress_migrate_schema_current');
		if(!$counter){
			$counter = 0;
		}

		$counter++;
		update_option('_seopress_migrate_schema_current', $counter);

		error_log('[item] : ' . $post_id);
		if (!isset($post_id)) {
			return false;
		}

		seopress_migrate_schema_by_post_id($post_id);

		return false;
	}

	protected function complete()
	{
		parent::complete();
		error_log("[complete batch]");
		delete_option('_seopress_migrate_schema');

		global $wpdb;

		$query = 'SELECT * ';
		$query .= "FROM {$wpdb->options} o ";
		$query .= 'WHERE 1=1 ';
		$query .= "AND o.option_name LIKE '_seopress_prepare_batch_%' ";

		$batchs = $wpdb->get_results($query, ARRAY_A);

		// Am I the last batch?
		if(!empty($batchs)){
			return;
		}
		error_log("[LAST batch]");
		delete_option('_seopress_migrate_schema_total');
		delete_option('_seopress_migrate_schema_current');
		update_option('_seopress_can_clean_migrate_schema', 1);

	}
}
