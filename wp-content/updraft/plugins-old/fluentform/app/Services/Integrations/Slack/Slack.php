<?php

namespace FluentForm\App\Services\Integrations\Slack;

use FluentForm\App\Modules\Form\FormDataParser;
use FluentForm\App\Modules\Form\FormFieldsParser;
use FluentForm\App\Services\Integrations\LogResponseTrait;
use FluentForm\Framework\Helpers\ArrayHelper;

class Slack
{
    use LogResponseTrait;

    /**
     * The slack integration settings of the form.
     *
     * @var array $settings
     */
    protected $settings = [];

    /**
     * Handle slack notifier.
     *
     * @param $submissionId
     * @param $formData
     * @param $form
     */
    public function handle($feed, $formData, $form, $entry)
    {
        $settings = $feed['processedValues'];

        $inputs = FormFieldsParser::getEntryInputs($form);

        $labels = FormFieldsParser::getAdminLabels($form, $inputs);

        $formData = FormDataParser::parseData((object)$formData, $inputs, $form->id);

        $title = __("New submission on " . $form->title, 'fluentform');

        $fields = [];

        foreach ($formData as $attribute => $value) {
            $value = str_replace('&', '&amp;', $value);
            $value = str_replace('<', '&lt;', $value);
            $value = str_replace('>', "&gt;", $value);

            $fields[] = [
                'title' => $labels[$attribute],
                'value' => $value,
                'short' => false
            ];
        }

        $slackHook = ArrayHelper::get($settings, 'webhook');

        $titleLink = admin_url('admin.php?page=fluent_forms&form_id='
            . $form->id
            . '&route=entries#/entries/'
            . $entry->id
        );

        $body = [
            'payload' => json_encode([
                'attachments' => [
                    [
                        'color'      => '#0078ff',
                        'fallback'   => $title,
                        'title'      => $title,
                        'title_link' => $titleLink,
                        'fields'     => $fields,
                        'footer'     => 'fluentform',
                        'ts'         => current_time('mysql')
                    ]
                ]
            ])
        ];

        $result = wp_remote_post($slackHook, [
            'method'      => 'POST',
            'timeout'     => 30,
            'redirection' => 5,
            'httpversion' => '1.0',
            'headers'     => [],
            'body'        => $body,
            'cookies'     => []
        ]);

        if (is_wp_error($result)) {
            $status = 'failed';
            $message = $result->get_error_message();
        } else {
            $message = $result['response'];
            $status = $result['response']['code'] == 200 ? 'success' : 'failed';
        }

        if($status == 'failed') {
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entry->id,
                'component' => 'SlackFeed',
                'status' => 'failed',
                'title' => 'Slack Webhook Failed',
                'description' => $message
            ]);
        } else {
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entry->id,
                'component' => 'SlackFeed',
                'status' => 'failed',
                'title' => 'Slack Webhook Success',
                'description' => 'Submission notification has been successfully delivered to slack channel'
            ]);
        }

        return array(
            'status'  => $status,
            'message' => $message
        );
    }
}
