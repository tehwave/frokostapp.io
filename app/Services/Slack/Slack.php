<?php

namespace App\Services\Slack;

use App;
use LogicException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\ClientException;

class Slack
{
    /**
     * The client to make a request with.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The configuration for the client.
     *
     * @var array
     */
    protected $clientConfig;

    /**
     * Set up the client.
     */
    public function __construct(array $clientConfig = null)
    {
        $this->clientConfig = $clientConfig ?: [
            'base_uri' => 'https://slack.com/api/',
            RequestOptions::VERIFY => App::isProduction(),
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Accept-Language' => App::getLocale(),
            ],
        ];
    }

    /**
     * Set the access token.
     *
     * @param  string $accessToken
     * @return self
     *
     * @throws LogicException
     */
    public function setAccessToken(string $accessToken): self
    {
        if (isset($this->client)) {
            throw new LogicException(
                "The client can't be set before the access token is set. Use the 'setAccessToken' method before 'setClient'."
            );
        }

        $bearerToken = "Bearer {$accessToken}";

        $this->clientConfig[RequestOptions::HEADERS]['Authorization'] = $bearerToken;

        return $this;
    }

    /**
     * Set the client.
     *
     * @param  \GuzzleHttp\Client $client
     * @return self
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Retrieve the client for requests.
     *
     * @return \GuzzleHttp\Client
     */
    public function getClient(): Client
    {
        return $this->client ?: new Client($this->clientConfig);
    }

    /**
     * Do request to Slack Web API.
     *
     * @param  string   $method
     * @param  string   $uri
     * @param  array    $options
     *
     * @return array
     */
    public function request($method, $uri, $options = []): array
    {
        $trimmedUri = ltrim($uri, '/');

        $response = $this->getClient()->request($method, $trimmedUri, $options);

        $contents = $response->getBody()->getContents();

        $decodedContents = json_decode($contents, true);

        return $decodedContents;
    }

    /**
     * GET request.
     *
     * @param  string $uri
     * @param  array  $data
     *
     * @return array
     */
    public function get($uri, $data = [])
    {
        $params = http_build_query($data);

        $trimmedUri = rtrim($uri, '?');

        return $this->request('GET', "{$trimmedUri}?{$params}");
    }

    /**
     * POST request.
     *
     * @param  string $uri
     * @param  array  $data
     * @param  array  $options
     *
     * @return array
     */
    public function post($uri, $data = [], $options = [])
    {
        return $this->request('POST', $uri, $data, array_merge([
            'form_params' => $data,
        ], $options));
    }

    /**
     * Retrieve list of users, excluding any deleted users or bots.
     *
     * @return \Illuminate\Support\Collection
     */
    public function users()
    {
        $members = $this->get('users.list')['members'];

        return collect($members)
            ->filter(function ($user) {

                // Deleted?
                if ($user['deleted']) {
                    return false;
                }

                // Bot?
                if ($user['is_bot']) {
                    return false;
                }

                if (in_array($user['id'], [
                    'USLACKBOT',
                ])) {
                    return false;
                }

                return true;
            });
    }

    /**
     * Only active users.
     *
     * @return \Illuminate\Support\Collection
     */
    public function activeUsers()
    {
        return $this->users()
            ->filter(function ($user) {
                $status = $this->get('users.getPresence', [
                    'user' => $user['id'],
                ]);

                return $status['presence'] === 'active';
            });
    }
}