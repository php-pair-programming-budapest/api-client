<?php

class NotFoundException extends \RuntimeException {}
class UnkownErrorException extends \RuntimeException {}

interface ApiClient
{
    /**
     * @param string $username
     *
     * @return User
     */
    public function getUser($username);
}

class MockApiClient implements ApiClient
{
    public function getUser($username)
    {
        return new User($username, 'Kocsis Máté');
    }
}

class HttpApiClient implements ApiClient
{
    private $httpClient;

    public function __construct(\Http\Client\Common\HttpMethodsClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function get($url)
    {
        return $this->httpClient->get($url);
    }

    public function getUser($username)
    {
        $response = $this->httpClient->get('https://www.api.entrainr.com/social/users/name/'.$username);

        if ($response->getStatusCode() > 299) {
            switch ($response->getStatusCode()) {
                case 404:
                    throw new NotFoundException('User not found');
                    break;

                default:
                    throw new UnkownErrorException();
            }
        }

        $user = json_decode((string) $response->getBody(), true);

        return new User($username, $user['data']['attributes']['profile']['name']['full_name']);
    }
}

class User {
    private $username;
    private $name;
    //..

    public function __construct($username, $name)
    {
        $this->username = $username;
        $this->name = $name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getName()
    {
        return $this->name;
    }
}

$client = Http\Adapter\Guzzle6\Client::createWithConfig(['verify' => false]);
$client = new \Http\Client\Common\HttpMethodsClient($client, new \Http\Message\MessageFactory\GuzzleMessageFactory());

$client = new HttpApiClient($client);
