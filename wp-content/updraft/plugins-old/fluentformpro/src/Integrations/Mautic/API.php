<?php

namespace FluentFormPro\Integrations\Mautic;

class API
{
    protected $apiUrl = '';

    protected $username = null;

    protected $password = null;

    public function __construct($apiUrl, $username, $password)
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
    }

    public function default_options()
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->username . ':' . $this->password),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ];
    }

    public function make_request($action, $options = array(), $method = 'GET')
    {

        /* Execute request based on method. */
        switch ($method) {
            case 'POST':
                $headers = $this->default_options();

                $endpointUrl = $this->apiUrl . $action;

                $args = [
                    'headers' => $headers,
                    'body'    => json_encode($options)
                ];

                $response = wp_remote_post($endpointUrl, $args);
                break;

            case 'GET':
                $headers = $this->default_options();
                $args = [
                    'headers' => $headers,
                    'body'    => json_encode($options)
                ];

                $response = wp_remote_request($this->apiUrl . $action, $args);
                break;
        }

        /* If WP_Error, die. Otherwise, return decoded JSON. */
        if (is_wp_error($response)) {
            return [
                'error'   => 'API_Error',
                'message' => $response->get_error_message()
            ];
        } else if ($response && $response['response']['code'] >= 300) {
            return [
                'error'   => 'API_Error',
                'message' => $response['response']['message']
            ];
        }
        return json_decode($response['body'], true);
    }

    /**
     * Test the provided API credentials.
     *
     * @access public
     * @return bool
     */
    public function auth_test()
    {
        return $this->make_request('contacts', [], 'GET');
    }


    public function subscribe($data)
    {
        $response = $this->make_request('leads', $data, 'POST');

        if (!empty($response['error'])) {
            return new \WP_Error('api_error', $response['message']);
        }
        return $response;
    }

    /**
     * Get all Forms in the system.
     *
     * @access public
     * @return array
     */
    public function getGroups()
    {
        $response = $this->make_request('groups', array(), 'GET');
        if (empty($response['error'])) {
            return $response;
        }
        return [];
    }

    public function getContactFields()
    {
        $response = $this->make_request('fields/contact', array(), 'GET');
        dd($response);
        if (empty($response['error'])) {
            return $response;
        }
        return false;
    }

}
