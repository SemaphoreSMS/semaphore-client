<?php

namespace Semaphore;

use GuzzleHttp\Client;

/**
 * Class SemaphoreClient
 * @package Semaphore
 */

class SemaphoreClient
{

    public $apiKey;
    public $senderId = null;
    protected $client;

    /**
     * Initializes the Semaphore API Client
     *
     * @param $apiKey - Your API Key
     * @param null $senderId - Optional Sender ID (Defaults to SEMAPHORE)
     */
    public function __construct( $apiKey, $senderId = null )
    {
        $this->apiKey = $apiKey;
        $this->senderId = $senderId;
        $this->client = new Client( ['base_uri' => 'http://api.semaphore.co/' ] );
    }

    /**
     * Check the balance of your account
     *
	 * @return \Psr\Http\Message\StreamInterface
     */
    public function balance()
    {
        $params = [
            'query' => [
                'api' => $this->apiKey,
            ]
        ];

        $response = $this->client->get( 'api/sms/account', $params);
        return $response->getBody();
    }

    /**
     * Send SMS message(s)
     *
     * @param $number - The recipient phone number(s)
     * @param $message - The message
     * @param null $senderId - Optional Sender ID (defaults to initialized value or SEMAPHORE)
     * @param bool|false $bulk - Optional send as bulk
	 * @return \Psr\Http\Message\StreamInterface
     */
    public function send( $number, $message, $senderId = null, $bulk = false )
    {
        $params = [
			'form_params' => [
				'api' => $this->apiKey,
				'message' => $message,
				'number' => $number,
				'from' => $this->senderId
			]
        ];

        if( $senderId != null )
        {
            $params[ 'form_params' ][ 'from' ] = $senderId;
        }

        if( $bulk != true )
        {
            $response = $this->client->post('api/sms', $params );
        } else {
            $response = $this->client->post('v3/bulk_api/sms', $params );
        }

        return $response->getBody();
    }

    /**
     * Retrieves data about a specific message
     *
     * @param $messageId - The encoded ID of the message
	 * @return \Psr\Http\Message\StreamInterface
     */
    public function message( $messageId )
    {
        $params = [
            'query' => [
                'api' => $this->apiKey,
            ]
        ];
        $response = $this->client->get( 'api/messages/' . urlencode( $messageId ), $params );
        return $response->getBody();
    }

    /**
     * Retrieves up to 100 messages, offset by page
     * @param null $page - Optional page for results past the initial 100
	 * @return \Psr\Http\Message\StreamInterface
     */
    public function messages( $page = null )
    {
        $params = [
            'query' => [
                'api' => $this->apiKey,
                'page' => $page,
            ]
        ];
        $response = $this->client->get( 'api/messages', $params );

        return $response->getBody();
    }

    /**
     * Retrieve messages between a range of Dates/Times
     *
     * @param $startDate - Automatically converted to UNIX timestamp via str_to_time
     * @param $endDate - Automatically converted to UNIX timestamp via str_to_time
	 * @return \Psr\Http\Message\StreamInterface
     */
    public function messagesByDate( $startDate, $endDate )
    {
        $startDate = strtotime( $startDate );
        $endDate = strtotime( $endDate );
        $params = [
            'query' => [
                'api' => $this->apiKey,
                'starts_at' => $startDate,
                'ends_at'  => $endDate
            ]
        ];
        $response = $this->client->get( 'api/messages/period', $params );
        return $response->getBody();
    }

    /**
     * Retrieve messages sent to a specific network
     *
     * @param $network - (globe, smart, smart_others)
	 * @return \Psr\Http\Message\StreamInterface
     */
    public function messagesByNetwork( $network )
    {
        $params = [
            'query' => [
                'api' => $this->apiKey,
                'telco' => $network,
            ]
        ];
        $response = $this->client->get( 'api/messages/network', $params );
        return $response->getBody();
    }

}