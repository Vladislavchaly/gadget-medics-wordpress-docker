<?php

namespace FluentForm\App\Services\Integrations\MailChimp;

use FluentForm\App\Services\ConditionAssesor;
use FluentForm\App\Services\Integrations\LogResponseTrait;
use FluentForm\Framework\Helpers\ArrayHelper;

trait MailChimpSubscriber
{
    use LogResponseTrait;

    /**
     * Enabled MailChimp feed settings.
     *
     * @var array $feeds
     */
    protected $feeds = [];

    /**
     * Required for api response logging
     * @var string
     */
    protected $metaKey = 'fluentform_mailchimp_feed';

    /**
     * Form input data.
     *
     * @param array $formData
     */
    public function setApplicableFeeds($formData)
    {
        $feeds = $this->getAll();

        foreach ($feeds as $feed) {
            if ($this->isApplicable($feed, $formData)) {
                $email = ArrayHelper::get(
                    $formData, ArrayHelper::get($feed->formattedValue, 'fieldEmailAddress')
                );

                if (is_string($email) && is_email($email)) {
                    $feed->formattedValue['fieldEmailAddress'] = $email;

                    $this->feeds[] = $feed;
                }
            }
        }
    }

    /**
     * Determine if the feed is eligible to be applied.
     *
     * @param $feed
     * @param $formData
     *
     * @return bool
     */
    public function isApplicable(&$feed, &$formData)
    {
        return ArrayHelper::get($feed->formattedValue, 'enabled') &&
            ArrayHelper::get($feed->formattedValue, 'list_id') &&
            ConditionAssesor::evaluate($feed->formattedValue, $formData);
    }

    /**
     * Subscribe a user to the list on form submission.
     *
     * @param $formData
     */
    public function subscribe($feed, $formData, $entry, $form)
    {

        $feedData = $feed['processedValues'];
        if (!is_email($feedData['fieldEmailAddress'])) {
            $feedData['fieldEmailAddress'] = ArrayHelper::get($formData, $feedData['fieldEmailAddress']);
        }

        if (!is_email($feedData['fieldEmailAddress'])) {
            return false;
        }

        $mergeFields = array_filter(ArrayHelper::get($feedData, 'merge_fields'));
        $status = ArrayHelper::isTrue($feedData, 'doubleOptIn') ? 'pending' : 'subscribed';

        $listId = $feedData['list_id'];

        $arguments = [
            'email_address' => $feedData['fieldEmailAddress'],
            'status'        => $status,
            'double_optin'  => ArrayHelper::isTrue($feedData, 'doubleOptIn'),
            'vip'           => ArrayHelper::isTrue($feedData, 'markAsVIP'),
        ];

        if($mergeFields) {
            $arguments['merge_fields'] = (object)$mergeFields;
        }

        if($entry->ip) {
            $arguments['ip_signup'] = $entry->ip;
        }

        if ($feedData['tags']) {
            $arguments['tags'] = explode(',', $feedData['tags']);
        }

        if ($feedData['note']) {
            $arguments['note'] = esc_attr($feedData['note']);
        }

        $settings = get_option('_fluentform_mailchimp_details');

        $MailChimp = new MailChimp($settings['apiKey']);

        $endPoint = 'lists/' . $listId . '/members/';
        $endPoint .= md5(strtolower( $feedData['fieldEmailAddress'] ));

        $result = $MailChimp->put($endPoint, $arguments);

        if($result && !is_wp_error($result) && isset($result['id'])) {
            return true;
        }
        return $result;
    }
}
