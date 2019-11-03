<?php

namespace App\Library;

class SlackApi
{
    /**
     * API Token.
     *
     * @var string
     */
    private $token;

    /**
     * @param string|null $token
     */
    public function __construct($token = null)
    {
        if ($token) {
            $this->token($token);
        }
    }

    /**
     * API Token.
     *
     * @param  string $token
     *
     * @return string
     */
    public function token($token = null)
    {
        if ($token) {
            $this->token = $token;

            return $this;
        }

        return $this->token;
    }

    /**
     * Do request to Slack Web API.
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $data
     *
     * @return array
     */
    public function request($method, $uri, $data = [])
    {
        $client = new \GuzzleHttp\Client();

        $trimmedUri = ltrim($uri, '/');

        $url = "https://slack.com/api/{$trimmedUri}";

        $options = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$this->token()}",
            ],
        ];

        if ($method !== 'GET') {
            $options['json'] = $data;
            $options['headers']['Content-Type'] = 'application/json; charset=utf-8';
        }

        try {
            $response = $client->request($method, $url, $options);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e;
        }

        $body = $response->getBody();

        $decodedResponse = json_decode($body, true);

        return $decodedResponse;
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
     *
     * @return array
     */
    public function post($uri, $data = [])
    {
        return $this->request('POST', $uri, $data);
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
     * Only online users.
     *
     * @return \Illuminate\Support\Collection
     */
    public function onlineUsers()
    {
        return $this->users()
            ->filter(function ($user) {
                $status = $this->get('users.getPresence', [
                    'user' => $user['id'],
                ]);

                return $status['online'];
            });
    }
}