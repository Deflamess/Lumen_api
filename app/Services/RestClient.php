<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RestClient implements RestClientInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Create GET request
     *
     * @param $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url)
    {
        try{
            $request = $this->client->request('GET', $url);
            if ($request->getStatusCode() != Response::HTTP_OK) {
                throw new \Exception('Error' . $request->getStatusCode());
            }

            $content = $request->getBody()->getContents();
            return json_decode($content, true);


        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function post(array $data)
    {
        // TODO: Implement post() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function put($id, array $data)
    {
        // TODO: Implement put() method.
    }

}
