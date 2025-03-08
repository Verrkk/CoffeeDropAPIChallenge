<?php

namespace App\Services;

use GuzzleHttp\Client;

class PostcodeService
{
    protected $client;
    protected $apiUrl = 'https://api.postcodes.io/postcodes/';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCoordinates($postcode)
    {
        try {
            $response = $this->client->get($this->apiUrl . $postcode);
            $data = json_decode($response->getBody()->getContents(), true);

            if ($data['status'] == 200) {
                return [
                    'latitude' => $data['result']['latitude'],
                    'longitude' => $data['result']['longitude']
                ];
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
