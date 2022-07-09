<?php

namespace FluentFormPro\Integrations\ConstantContact;

use FluentForm\App\Services\Integrations\IntegrationManager;
use FluentForm\Framework\Foundation\Application;
use FluentForm\Framework\Helpers\ArrayHelper;

class Bootstrap extends IntegrationManager
{
    public function __construct(Application $app)
    {
        parent::__construct(
            $app,
            'ConstantContact',
            'constatantcontact',
            '_fluentform_constantcontact_settings',
            'constantcontact_feed',
            26
        );

        $this->logo = $this->app->url('public/img/integrations/constantcontact.png');

        $this->description = 'Connect ConstantContact with WP Fluent Forms and create subscriptions forms right into WordPress and grow your list.';

        $this->registerAdminHooks();

        add_action('admin_init', function () {
            $this->verifyCode();
        });

//        add_filter('fluentform_notifying_async_constatantcontact', '__return_false');
    }

    public function getGlobalFields($fields)
    {
        return [
            'logo'               => $this->logo,
            'menu_title'         => __('ConstantContact API Settings', 'fluentformpro'),
            'menu_description'   => __('Constant Contact makes it easy to send email newsletters to your customers, manage your subscriber lists, and track campaign performance. Use WP Fluent Forms to collect customer information and automatically add it to your Constant Contact subscriber list. If you don\'t have a Constant Contact account, you can <a href="https://www.constantcontact.com/">sign up for one here</a>.', 'fluentformpro'),
            'valid_message'      => __('Your ConstantContact API Key is valid', 'fluentformpro'),
            'invalid_message'    => __('Your ConstantContact API Key is not valid', 'fluentformpro'),
            'save_button_text'   => __('Authenticate with Constant Contact', 'fluenform'),
            'config_instruction' => $this->getConfigInstractions(),
            'fields'             => [
                'apiKey'      => [
                    'type'        => 'text',
                    'placeholder' => 'API Key',
                    'label_tips'  => __("Enter your ConstantContact API Key, if you do not have <br>Please login to your ConstantContact account and go to<br>Profile -> Account Settings -> Account Info", 'fluentformpro'),
                    'label'       => __('ConstantContact API Key', 'fluentformpro'),
                ],
                'accessToken' => [
                    'type'        => 'text',
                    'placeholder' => 'App Secret',
                    'label_tips'  => __("Enter your ConstantContact Access Token, if you do not have <br>Please login to your ConstantContact and find the access token", 'fluentformpro'),
                    'label'       => __('ConstantContact App Secret', 'fluentformpro'),
                ]
            ],
            'hide_on_valid'      => true,
            'discard_settings'   => [
                'section_description' => 'Your ConstactContact API integration is up and running',
                'button_text'         => 'Disconnect ConstantContact',
                'data'                => [
                    'apiKey' => ''
                ],
                'show_verify'         => true
            ]
        ];
    }

    public function getGlobalSettings($settings = [])
    {
        $globalSettings = get_option($this->optionKey);
        if (!$globalSettings) {
            $globalSettings = [];
        }
        $defaults = [
            'apiKey'      => '',
            'accessToken' => '',
            'status'      => ''
        ];

        return wp_parse_args($globalSettings, $defaults);
    }

    public function saveGlobalSettings($settings)
    {
        if (!$settings['apiKey']) {
            $integrationSettings = [
                'apiKey'      => '',
                'accessToken' => '',
                'status'      => false
            ];
            // Update the reCaptcha details with siteKey & secretKey.
            update_option($this->optionKey, $integrationSettings);
            wp_send_json_success([
                'message'      => __('Your settings has been updated', 'fluentformpro'),
                'status'       => false,
                'require_load' => true
            ], 200);
        }

        $integrationSettings = [
            'apiKey'      => $settings['apiKey'],
            'accessToken' => $settings['accessToken'],
            'status'      => false,
            'auth_intent' => 'initialized'
        ];
        update_option($this->optionKey, $integrationSettings);

        $authUrl = $this->getAuthUlr($settings['apiKey']);

        wp_send_json_success([
            'message'      => 'You are redirect to athenticate',
            'redirect_url' => $authUrl
        ], 200);
    }

    public function pushIntegration($integrations, $formId)
    {
        $integrations[$this->integrationKey] = [
            'title'                 => $this->title . ' Integration',
            'logo'                  => $this->logo,
            'is_active'             => $this->isConfigured(),
            'configure_title'       => 'Configration required!',
            'global_configure_url'  => admin_url('admin.php?page=fluent_forms_settings#general-constatantcontact-settings'),
            'configure_message'     => 'ConstantContact is not configured yet! Please configure your ConstantContact api first',
            'configure_button_text' => 'Set ConstantContact API'
        ];
        return $integrations;
    }

    public function getIntegrationDefaults($settings, $formId)
    {
        return [
            'name'            => '',
            'list_id'         => '',
            'email_address'   => '',
            'first_name'      => '',
            'last_name'       => '',
            'job_title'       => '',
            'company_name'    => '',
            'home_number'     => '',
            'work_number'     => '',
            'address_line_1'  => '',
            'city_name'       => '',
            'state_name'      => '',
            'zip_code'        => '',
            'country_name'    => '',
            'custom_fields'   => (object)[],
            'conditionals'    => [
                'conditions' => [],
                'status'     => false,
                'type'       => 'all'
            ],
            'update_if_exist' => false,
            'enabled'         => true
        ];
    }

    public function getSettingsFields($settings, $formId)
    {
        return [
            'fields'              => [
                [
                    'key'         => 'name',
                    'label'       => 'Name',
                    'required'    => true,
                    'placeholder' => 'Your Feed Title',
                    'component'   => 'text'
                ],
                [
                    'key'         => 'list_id',
                    'label'       => 'Constant Contact List',
                    'placeholder' => 'Select ConstantContact Mailing List',
                    'tips'        => 'Select the ConstantContact Mailing List you would like to add your contacts to.',
                    'component'   => 'list_ajax_options',
                    'options'     => $this->getLists(),
                ],
                [
                    'key'                => 'custom_fields',
                    'require_list'       => true,
                    'label'              => 'Map Fields',
                    'tips'               => 'Select which Fluent Form fields pair with their<br /> respective ConstantContact fields.',
                    'component'          => 'map_fields',
                    'field_label_remote' => 'ConstantContact Field',
                    'field_label_local'  => 'Form Field',
                    'primary_fileds'     => [
                        [
                            'key'           => 'email_address',
                            'label'         => 'Email Address',
                            'required'      => true,
                            'input_options' => 'emails'
                        ],
                        [
                            'key'   => 'first_name',
                            'label' => 'First Name'
                        ],
                        [
                            'key'   => 'last_name',
                            'label' => 'Last Name'
                        ],
                        [
                            'key'   => 'job_title',
                            'label' => 'Job Title'
                        ],
                        [
                            'key'   => 'company_name',
                            'label' => 'Company name'
                        ],
                        [
                            'key'   => 'home_number',
                            'label' => 'Home Phone Number'
                        ],
                        [
                            'key'   => 'work_number',
                            'label' => 'Work Phone Number'
                        ],
                        [
                            'key'   => 'address_line_1',
                            'label' => 'Address'
                        ],
                        [
                            'key'   => 'city_name',
                            'label' => 'City'
                        ],
                        [
                            'key'   => 'state_name',
                            'label' => 'State'
                        ],
                        [
                            'key'   => 'zip_code',
                            'label' => 'ZIP Code'
                        ],
                        [
                            'key'   => 'country_name',
                            'label' => 'Country'
                        ]
                    ]
                ],
                [
                    'require_list' => true,
                    'key'          => 'conditionals',
                    'label'        => 'Conditional Logics',
                    'tips'         => 'Allow ConstantContact integration conditionally based on your submission values',
                    'component'    => 'conditional_block'
                ],
                [
                    'require_list'    => true,
                    'key'             => 'enabled',
                    'label'           => 'Status',
                    'component'       => 'checkbox-single',
                    'checkobox_label' => 'Enable This feed'
                ]
            ],
            'button_require_list' => true,
            'integration_title'   => $this->title
        ];
    }

    protected function getLists()
    {
        $api = $this->getRemoteApi();
        $lists = $api->get_lists();
        $formateddLists = [];

        if(is_wp_error($lists)) {
            return $formateddLists;
        }

        foreach ($lists['lists'] as $list) {
            $formateddLists[$list['list_id']] = $list['name'];
        }
        return $formateddLists;
    }

    public function getMergeFields($list, $listId, $formId)
    {
        $api = $this->getRemoteApi();
        $fields = $api->get_custom_fields();
        $formattedFields = [];
        foreach ($fields['custom_fields'] as $field) {
            $formattedFields[$field['custom_field_id']] = $field['label'];
        }
        return $formattedFields;
    }

    protected function getConfigInstractions()
    {
        ob_start();
        ?>
        <div><h4>An application must be created with Constant Contact to get your API Key and App Secret. </h4>
            <ol>
                <li>Login to the <a href="https://app.constantcontact.com/pages/dma/portal" target="_blank">Constant
                        Contact V3 Portal</a> and create a "New Application".
                </li>
                <li>Enter "WP Fluent Forms" for the application name and click "Save".</li>
                <li>Copy your Constant Contact API Key and paste it into the API Key field below.</li>
                <li>Click the "Generate Secret" button, go through the secret generation process and paste the resulted
                    key in the "App Secret" field below.
                </li>
                <li>Paste the URL <strong><?php echo admin_url('admin.php'); ?></strong> into the
                    Redirect URI field and click "Authenticate with Constant Contact" in the top right corner of the
                    screen.
                </li>
            </ol>
        </div>
        <?php
        return ob_get_clean();
    }

    protected function getAuthUlr($app_key)
    {
        // Get base OAuth URL.
        $auth_url = 'https://api.cc.email/v3/idfed';

        // Prepare OAuth URL parameters.
        $auth_params = array(
            'response_type' => 'code',
            'client_id'     => $app_key,
            'scope'         => 'contact_data',
            'redirect_uri'  => admin_url('admin.php'),
            'state'         => 'fluenformFormsConstantcontactVerify',
        );

        // Add parameters to OAuth url.
        $auth_url = add_query_arg($auth_params, $auth_url);

        return $auth_url;
    }


    public function verifyCode()
    {
        if (isset($_GET['state']) && $_GET['state'] == 'fluenformFormsConstantcontactVerify') {

            $api = $this->getRemoteApi();

            $tokens = $api->getTokens('', sanitize_text_field($_REQUEST['code']));
            $settings = $this->getGlobalSettings();

            if (!$tokens) {
                $settings['auth_intent'] = 'error';
                $settings['status'] = false;
            } else {
                $settings['access_token'] = $tokens['access_token'];
                $settings['refresh_token'] = $tokens['refresh_token'];
                $settings['auth_intent'] = 'completed';
                $settings['status'] = true;
            }
            update_option($this->optionKey, $settings);
            wp_safe_redirect(admin_url('admin.php?page=fluent_forms_settings#general-constatantcontact-settings'));
            die();
        }
    }


    /*
     * Form Submission Hooks Here
     */
    public function notify($feed, $formData, $entry, $form)
    {
        $feedData = $feed['processedValues'];

        if (!is_email($feedData['email_address'])) {
            $feedData['email_address'] = ArrayHelper::get($formData, $feedData['email_address']);
        }

        if (!is_email($feedData['email_address']) || !$feedData['list_id']) {
            // No Valid email found
            return;
        }

        /* Prepare audience member import array. */
        $subscriber_details = array(
            'list_memberships' => array(
                $feedData['list_id']
            ),
            'custom_fields'    => array(),
            'phone_numbers'    => array(),
        );


        $mapFields = ArrayHelper::only($feedData, [
            'email_address',
            'first_name',
            'last_name',
            'job_title',
            'company_name',
            'home_number',
            'work_number',
            'address_line_1',
            'city_name',
            'state_name',
            'zip_code',
            'country_name',
        ]);


        foreach ($mapFields as $field_name => $field_value) {
            if(!$field_value) {
                continue;
            }
            switch ( $field_name ) {
                case 'email_address':
                    $field_value = array(
                        'address' => $field_value,
                    );
                    break;
                case 'home_number':
                case 'work_number':
                    $subscriber_details['phone_numbers'][] = array(
                        'phone_number' => $field_value,
                        'kind'         => str_replace( '_number', '', $field_name ),
                    );

                    $field_name = 'phone_numbers';
                    break;
            }

            $addressTypes = [
                'address_line_1' => 'street',
                'city_name' => 'city',
                'state_name' => 'state',
                'zip_code' => 'postal_code',
                'country_name' => 'country'
            ];

            if(in_array($field_name, array_keys($addressTypes))) {
                $field_value = trim( $field_value );

                if ( ! isset( $subscriber_details['street_addresses'] ) ) {
                    $subscriber_details['street_addresses']    = array();
                    $subscriber_details['street_addresses'][0] = array(
                        'kind' => 'home',
                    );
                }
                $subscriber_details['street_addresses'][0][ $addressTypes[$field_name] ] = $field_value;
                continue;
            }

            if ( ! isset( $subscriber_details[ $field_name ] ) ) {
                $subscriber_details[ $field_name ] = $field_value;
            }

        }


        if($customFiels = ArrayHelper::get($feedData, 'custom_fields')) {
            foreach ($customFiels as $fieldKey => $fieldValue) {
                if(!$fieldValue) {
                    continue;
                }
                $subscriber_details['custom_fields'][] = array(
                    'custom_field_id' => $fieldKey,
                    'value'           => $field_value,
                );
            }
        }

        $subscription_results = $this->subscribeToList( $subscriber_details, $feedData );

        if ( !is_wp_error( $subscription_results ) ) {
            // it's success
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entry->id,
                'component' => $this->integrationKey,
                'status' => 'success',
                'title' => $feed['settings']['name'],
                'description' => 'Constant Contact has been successfully initialed and pushed data'
            ]);
        } else {
            // It's failed
            do_action('ff_log_data', [
                'parent_source_id' => $form->id,
                'source_type' => 'submission_item',
                'source_id' => $entry->id,
                'component' => $this->integrationKey,
                'status' => 'failed',
                'title' => $feed['settings']['name'],
                'description' => $subscription_results->get_error_message()
            ]);
        }

    }


    private function subscribeToList( $subscriber_details = array(), $feedData ) {

        $api = $this->getRemoteApi();

        foreach ( $subscriber_details as $key => $detail ) {
            if ( is_string( $detail ) ) {
                $detail = trim( $detail );
            }

            if ( empty( $detail ) ) {
                unset( $subscriber_details[ $key ] );
            }
        }


        $contactId = null;
        $contact = $api->contact_exists( $subscriber_details['email_address']['address'] );

        $action  = ( $contact ) ? 'updated' : 'added';

        if ( $action === 'updated' ) {
            $contactId = $contact['contact_id'];
            $subscriber_details['list_memberships'] = array_merge(
                $subscriber_details['list_memberships'],
                $contact['list_memberships']
            );

            try {
                $subscriber_details['custom_fields'] = $this->mergeCustomFields( $subscriber_details, $feedData );
                $subscriber_details['phone_numbers'] = $this->mergePhoneNumbers( $subscriber_details, $feedData );
            } catch (\Exception $e) {

            }
        }

        // Add or update subscriber.
        $result = $api->update_contact( $subscriber_details, $contactId );

        if ( is_wp_error( $result ) ) {
            // Add extra notes for certain API errors.
            switch ( $result->get_error_message() ) {
                case 'Conflict':
                    $message = esc_html__( 'You\'re trying to add a contact which has been deleted from your ConstantContact account. Currently you have to manually revive the contact via the Constant Contact website.', 'fluentformpro' );
                    break;
                default:
                    $message = $result->get_error_message();
            }
            return new \WP_Error( 'constantcontact_api_error', $message );
        }

        // Log that the subscription was added or updated.
        return true;
    }

    private function mergeCustomFields($subscriber_details, $feedData)
    {

        $api = $this->getRemoteApi();
        $contact = $api->get_contact_details( $subscriber_details['email_address']['address'], 'custom_fields' );

        if ( isset( $contact['custom_fields'] ) && $contact['custom_fields'] ) {
            $submitted_custom_fields = $subscriber_details['custom_fields'];
            if ( count( $contact['custom_fields'] ) >= 25 ) {
                $subscriber_details['custom_fields'] = array();
            } elseif ( empty( $submitted_custom_fields ) ) {
                $subscriber_details['custom_fields'] = $contact['custom_fields'];
            } else {
                $current_custom_field_ids    = wp_list_pluck( $contact['custom_fields'], 'custom_field_id' );
                $feed_custom_field_ids       = wp_list_pluck( $submitted_custom_fields, 'custom_field_id' );
                $current_custom_field_values = wp_list_pluck( $contact['custom_fields'], 'value' );

                $subscriber_details['custom_fields'] = array();

                foreach ( $current_custom_field_ids as $key => $custom_field_id ) {
                    if ( ! in_array( $custom_field_id, $feed_custom_field_ids, true ) ) {
                        $subscriber_details['custom_fields'][] = array(
                            'custom_field_id' => $custom_field_id,
                            'value'           => $current_custom_field_values[ $key ],
                        );
                    }
                }
                $subscriber_details['custom_fields'] = array_merge( $subscriber_details['custom_fields'], $submitted_custom_fields );

                if ( count( $subscriber_details['custom_fields'] ) > 25 ) {
                    $subscriber_details['custom_fields'] = array_slice( $subscriber_details['custom_fields'], 0, 25 );
                }
            }
        }
        return isset( $subscriber_details['custom_fields'] ) ? $subscriber_details['custom_fields'] : array();
    }

    private function mergePhoneNumbers($subscriber_details, $feedData)
    {
        $api = $this->getRemoteApi();
        $contact = $api->get_contact_details( $subscriber_details['email_address']['address'], 'phone_numbers' );

        if ( isset( $contact['phone_numbers'] ) ) {
            $submitted_phone_numbers = $subscriber_details['phone_numbers'];
            if ( count( $contact['phone_numbers'] ) >= 2 ) {
                $subscriber_details['phone_numbers'] = array();
            } elseif ( empty( $submitted_phone_numbers ) ) {
                $subscriber_details['phone_numbers'] = $contact['phone_numbers'];
            } else {
                $subscriber_details['phone_numbers'] = array_merge( $contact['phone_numbers'], $subscriber_details['phone_numbers'] );
                if ( count( $subscriber_details['phone_numbers'] ) > 2 ) {
                    $subscriber_details['phone_numbers'] = array_slice( $subscriber_details['phone_numbers'], 0, 2 );
                }
            }
        }

        return isset( $subscriber_details['phone_numbers'] ) ? $subscriber_details['phone_numbers'] : array();
    }

    /**
     * Get OAuth Redirect URI for custom Constant Contact app.
     *
     * @since  1.0
     *
     * @return string
     */
    protected function getRedirectUri()
    {
        return admin_url('admin.php', 'https');
    }

    protected function getRemoteApi()
    {
        $settings = $this->getGlobalSettings();
        return new API($settings, $this->optionKey);
    }
}
