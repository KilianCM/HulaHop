<?php


namespace App\Services;


use GuzzleHttp\Client;

class BoardGamesApi
{
    private $client;
    private $clientId;

    public function __construct(string $baseUrl, string $clientId)
    {
        $this->clientId = $clientId;
        $this->client = new Client([
            "base_uri" => $baseUrl
        ]);
    }

    public function getGamesBestDeals(float $discount)
    {
        $response = $this->client->get("/search?client_id=" . $this->clientId . "&gt_discount=" . $discount . "&limit=25");
        $content = json_decode($response->getBody()->getContents(), true);
        return $content["games"];
    }
}