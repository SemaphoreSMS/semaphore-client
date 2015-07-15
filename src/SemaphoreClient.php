<?php
/**
 * Created by PhpStorm.
 * User: aalabiso
 * Date: 7/13/15
 * Time: 11:37 AM
 */

namespace Semaphore;

use Guzzle\Http\Client;


class SemaphoreClient
{

    public $apiKey;
    public $senderId = null;
    protected $client;

    public function __construct( $apiKey, $senderId = null )
    {
        $this->apiKey = $apiKey;
        $this->senderId = $senderId;
        $this->client = new Client( 'http://api.semaphore.co/' );

    }


    public function checkBalance()
    {

    }

    public function sendMessage( $number, $message, $senderId = null )
    {
        $postFields = array(
            'api' => $this->apiKey,
            'message' => $message,
            'number' => $number,
            'senderId' => $this->senderId;
        );

        if( $senderId != null )
        {
            $postFields[ 'senderId' ] = $senderId;
        }

        $request = $this->client->post('api/sms')->addPostFields( $postFields );
        $response = $request->send();
    }

}