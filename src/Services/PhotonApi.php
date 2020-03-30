<?php


namespace App\Services;



use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class PhotonApi
{
    private $client;

    public function __construct(string $baseUrl)
    {
        $this->client = new Client([
            "base_uri" => $baseUrl
        ]);
    }

    public function transformAddressToCoordinate(string $address): ?array {
        $response = $this->client->get("?q=" . $address);
        if($response->getStatusCode() != Response::HTTP_OK) {
            return null;
        }

        $content = json_decode($response->getBody()->getContents(), true);
        try {
            return $content["features"][0]["geometry"]["coordinates"];
        } catch (\Exception $exception) {
            return null;
        }
    }
}