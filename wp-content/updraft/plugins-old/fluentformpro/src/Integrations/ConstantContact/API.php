<?php

namespace FluentFormPro\Integrations\ConstantContact;
	
use FluentForm\Framework\Helpers\ArrayHelper;

class API
{
    /**
     * Base Constant Contact API URL.
     *
     * @since  1.0
     * @var    string
     * @access protected
     */
    protected $api_url = 'https://api.cc.email/v3/';

    /**
     * Constant Contact authentication data.
     *
     * @since  1.0
     * @access protected
     * @var    array $auth_token Constant Contact authentication data.
     */
    protected $auth_token = null;

    /**
     * Initialize Slack API library.
     *
     * @since  1.0
     *
     * @param  array $auth_token Authentication token data.
     */
    public function __construct( $auth_token = null ) {

        $this->auth_token = $auth_token;

    }

    /**
     * Make API request.
     *
     * @since  1.0
     *
     * @param  string $path Request path.
     * @param  array  $options Request option.
     * @param  string $method (default: 'GET') Request method.
     *
     * @return array|int|WP_Error Results.
     */
    public function make_request( $path, $options = array(), $method = 'GET' ) {
        $auth_token = $this->auth_token;

        // Get API URL.
        $api_url = $this->api_url;

        // Add options if this is a GET request.
        $request_options = ( 'GET' === $method && ! empty( $options ) ) ? '?' . http_build_query( $options ) : null;

        // Build request URL.
        $request_url = $api_url . $path . $request_options;

        // Build request arguments.
        $args = array(
            'body'    => 'GET' !== $method ? json_encode( $options ) : null,
            'method'  => $method,
            /**
             * Sets the HTTP timeout, in seconds, for the request.
             *
             * @param int    30           The timeout limit, in seconds. Defaults to 30.
             * @param string $request_url The request URL.
             *
             * @return int
             */
            'timeout' => apply_filters( 'http_request_timeout', 30, $request_url ),
            'headers' => array(
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $auth_token['access_token'],
                'Content-Type'  => 'application/json; charset=' . get_option( 'blog_charset' ),
                'Cache-Control' => 'no-cache',
            ),
        );

        // Execute request.
        $response = wp_remote_request( $request_url, $args );


        // If WP_Error, return it. Otherwise, return decoded JSON.
        if ( is_wp_error( $response ) ) {
            return $response;
        }

        // Decode response body.
        $response['body'] = json_decode( $response['body'], true );

        // Get the response code.
        $response_code = wp_remote_retrieve_response_code( $response );

        if ( $response_code === 401 ) {
            $this->getTokens( $auth_token['refresh_token'] );
            if ( ! empty( $this->auth_token['access_token'] ) && ! empty( $this->auth_token['refresh_token'] ) ) {
                return $this->make_request( $path, $options, $method );
            }
            return new \WP_Error( 'token_expired', esc_html__( 'Tokens expired and failed to refresh.', 'gravityformsconstantcontact' ) );
        } elseif ( ! in_array( $response_code, array( 200, 201 ), true ) ) {
            $errors = new \WP_Error( 'constantcontact_api_error', wp_remote_retrieve_response_message( $response ), array( 'status' => $response_code ) );

            // Add errors if available.
            if ( isset( $response['body']['error_key'] ) ) {
                $errors->add( 'constantcontact_api_error', $response['body']['error_message'] );
            } elseif ( isset( $response['body'][0]['error_key'] ) ) {
                foreach ( $response['body'] as $body ) {
                    $errors->add( 'constantcontact_api_error', $body['error_message'] );
                }
            }

            return $errors;
        }

        // Remove links from response.
        unset( $response['body']['_links'] );

        return $response['body'];
    }

    /**
     * Get contacts.
     *
     * @since  1.0
     *
     * @param array $options API options.
     *
     * @return array|WP_Error
     */
    public function get_contacts( $options = array() ) {
        $results = $this->make_request( 'contacts', $options );

        return $results['contacts'];
    }

    /**
     * Get lists.
     *
     * @since 1.0
     *
     * @return array|int|WP_Error
     */
    public function get_lists() {
        return $this->make_request( 'contact_lists', array( 'include_count' => true ) );
    }

    /**
     * Get a list.
     *
     * @since 1.0
     *
     * @param string $list_id List id.
     *
     * @return array|bool|WP_Error
     */
    public function get_list( $list_id ) {
        return $this->make_request( "contact_lists/{$list_id}" );
    }

    /**
     * Check whether a subscriber exists at $email
     *
     * @since 1.0
     *
     * @param string $email Email address.
     *
     * @return bool|array|WP_Error False if not found; array contact details if found.
     */
    public function contact_exists( $email = '' ) {

        if ( !is_email( $email ) ) {
            return false;
        }

        $result = $this->get_contact_details( $email );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        return empty( $result ) ? false : $result;
    }

    /**
     * Get subscriber details.
     *
     * @since 1.0
     *
     * @param string $email Email address.
     * @param string $include Specify which contact subresources to include in the response.
     *
     * @return array|false|WP_Error False if invalid email or contact not found. Array of contact details if found.
     */
    public function get_contact_details( $email = '', $include = 'list_memberships' ) {

        if ( !is_email( $email ) ) {
            return false;
        }

        $results = $this->get_contacts(
            array(
                'email'   => $email,
                'include' => $include,
            )
        );

        if ( is_wp_error( $results ) ) {
            return $results;
        }

        return empty( $results ) ? false : $results[0];
    }

    /**
     * Add or update contact details.
     *
     * @since 1.0
     *
     * @param array       $contact_details Contact details.
     * @param bool|string $contact_id      Contact ID.
     *
     * @return array|WP_Error Results.
     */
    public function update_contact( $contact_details = array(), $contact_id = false ) {
        if ( ! $contact_id ) {
            $contact_details['create_source'] = 'Contact';
            return $this->make_request( 'contacts', $contact_details, 'POST' );
        } else {
            $contact_details['update_source'] = 'Contact';
            return $this->make_request( 'contacts/' . $contact_id, $contact_details, 'PUT' );
        }
    }

    /**
     * Get contact custom fields.
     *
     * @since 1.0
     *
     * @return array|WP_Error Results.
     */
    public function get_custom_fields() {
        return $this->make_request( 'contact_custom_fields' );
    }

    /**
     * Get tokens with authorization code or refresh token.
     *
     * @since 1.0
     *
     * @param string $refresh_token Refresh token.
     *
     * @return array|bool
     */
    public function getTokens($refresh_token = '', $code = '')
    {
        // Get base OAuth URL.
        $auth_url = 'https://idfed.constantcontact.com/as/token.oauth2';

        // Prepare OAuth URL parameters.
        if (empty($code)) {
            $auth_params = array(
                'grant_type'    => 'refresh_token',
                'refresh_token' => $refresh_token,
                'scope'         => 'contact_data'
            );
        } else {
            $auth_params = array(
                'grant_type'   => 'authorization_code',
                'code'         => $code,
                'scope'        => 'contact_data',
                'redirect_uri' => $this->getRedirectUri(),
            );
        }

        // Add parameters to URL.
        $auth_url = add_query_arg($auth_params, $auth_url);

        // Execute request.
        $settings = get_option('_fluentform_constantcontact_settings');
        $args = array(
            /**
             * Sets the HTTP timeout, in seconds, for the request.
             *
             * @param int    30        The timeout limit, in seconds. Defaults to 30.
             * @param string $auth_url The request URL.
             *
             * @return int
             */
            'timeout' => apply_filters('http_request_timeout', 30, $auth_url),

            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($settings['apiKey'] . ':' . $settings['accessToken']),
            ),
        );


        $response = wp_remote_post($auth_url, $args);

        // If there was an error, return false.
        if (is_wp_error($response)) {
            return false;
        }

        // Get response body.
        $response_body = wp_remote_retrieve_body($response);
        $response_body = json_decode($response_body, true);


        $tokens = array(
            'access_token'  => ArrayHelper::get($response_body, 'access_token'),
            'refresh_token' => ArrayHelper::get($response_body, 'refresh_token'),
        );

        $this->auth_token = $tokens;
        return $tokens;
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
}
