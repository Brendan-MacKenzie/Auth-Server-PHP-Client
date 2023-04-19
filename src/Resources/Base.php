<?php

namespace BrendanMacKenzie\AuthServerClient\Resources;

use BrendanMacKenzie\AuthServerClient\Common\HttpClient;
use BrendanMacKenzie\AuthServerClient\Common\ResponseError;
use BrendanMacKenzie\AuthServerClient\Exceptions\ServerException;
use BrendanMacKenzie\AuthServerClient\Exceptions\RequestException;

/**
 * Class Base.
 */
class Base
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string The resource endpoint as it is known at the server
     */
    protected $resourceEndpoint;

    /**
     * @var \BrendanMacKenzie\AuthServerClient\Objects\Profile
     */
    protected $object;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getResourceEndpoint(): string
    {
        return $this->resourceEndpoint;
    }

    /**
     * @param mixed $resourceEndpoint
     */
    public function setResourceEndpoint($resourceEndpoint): void
    {
        $this->resourceEndpoint = $resourceEndpoint;
    }

    /**
     * @return \BrendanMacKenzie\AuthServerClient\Objects\Profile
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param string|null $body
     * @return \BrendanMacKenzie\AuthServerClient\Objects\Profile|null
     *
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\AuthenticateException
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\RequestException
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\ServerException
     */
    public function processRequest(?string $body)
    {
        if ($body === null) {
            throw new ServerException('Got an invalid response from the server.');
        }

        try {
            $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($body->errors) || !$body->data) {
            $responseError = new ResponseError($body);
            throw new RequestException($responseError->getErrorString());
        }

        if ($body->data) {
            if (is_null($body->data)) {
                return true;
            }

            return $this->object->loadFromStdclass($body->data);
        }
    }

    /**
     * @no-named-arguments
     *
     * @param mixed $object
     * @param array|null $query
     *
     * @return \BrendanMacKenzie\AuthServerClient\Objects\Profile|null
     *
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\AuthenticateException
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\HttpException
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\RequestException
     * @throws BrendanMacKenzie\AuthServerClient\Exceptions\ServerException
     * @throws \JsonException
     */
    public function create($object, ?array $query = null)
    {
        $body = $object->toArray();
        $data = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->resourceEndpoint,
            $query,
            $body
        );

        return $this->processRequest($data);
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }
}
