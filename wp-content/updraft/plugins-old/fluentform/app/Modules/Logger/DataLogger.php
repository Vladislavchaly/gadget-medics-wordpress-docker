<?php namespace FluentForm\App\Modules\Logger;

use FluentForm\App\Databases\Migrations\FormLogs;
use FluentForm\Framework\Foundation\Application;

class DataLogger
{
    public $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function log($data)
    {
        if (!$data) {
            return;
        }
        $data['created_at'] = current_time('mysql');

        if (!get_option('fluentform_db_fluentform_logs_added')) {
            FormLogs::migrate();
        }

        return wpFluent()->table('fluentform_logs')
            ->insert($data);
    }

    public function getLogsByEntry($entry_id, $sourceType = 'submission_item')
    {
        $logs = wpFluent()->table('fluentform_logs')
            ->where('source_id', $entry_id)
            ->where('source_type', $sourceType)
            ->orderBy('id', 'DESC')
            ->get();

        $logs = apply_filters('fluentform_entry_logs', $logs, $entry_id);

        wp_send_json_success([
            'logs' => $logs
        ], 200);
    }

    public function getAllLogs()
    {
        $limit = intval($_REQUEST['per_page']);
        $pageNumber = intval($_REQUEST['page_number']);

        $skip = ($pageNumber - 1) * $limit;

        global $wpdb;
        $logs = wpFluent()->table('fluentform_logs')
            ->select([
                'fluentform_logs.*'
            ])
            ->select(wpFluent()->raw( $wpdb->prefix.'fluentform_forms.title as form_title' ))
            ->join('fluentform_forms', 'fluentform_forms.id', '=', 'fluentform_logs.parent_source_id')
            ->orderBy('fluentform_logs.id', 'DESC')
            ->whereIn('fluentform_logs.source_type', ['submission_item', 'form_item'])
            ->offset($skip)
            ->limit($limit)
            ->get();
        $logs = apply_filters('fluentform_all_logs', $logs);

        $total = wpFluent()->table('fluentform_logs')->count();

        wp_send_json_success([
            'logs'  => $logs,
            'total' => $total
        ], 200);

    }

    public function deleteLogsByIds($ids = [])
    {
        if(!$ids) {
            $ids = wp_unslash($_REQUEST['log_ids']);
        }

        if(!$ids) {
            wp_send_json_error([
                'message' => 'No selections found'
            ], 423);
        }

       wpFluent()->table('fluentform_logs')
            ->whereIn('id', $ids)
           ->delete();

        wp_send_json_success([
            'message' => __('Selected logs successfully deleted', 'fluentform')
        ], 200);
    }

}
