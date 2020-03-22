<?php
declare(strict_types=1);
/**
 * Request.php
 * Copyright (c) 2020 james@firefly-iii.org
 *
 * This file is part of the Firefly III CSV importer
 * (https://github.com/firefly-iii/csv-importer).
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace GrumpyDictator\FFIIIApiSupport\Request;

use Exception;
use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiException;
use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Request
 */
abstract class Request
{
    protected const VALIDATION_ERROR_MSG = 'The given data was invalid.';
    /** @var string */
    private $base;
    /** @var string */
    private $token;
    /** @var string */
    private $uri;
    /** @var array */
    private $parameters;
    /** @var array */
    private $body;

    /**
     * @return array
     */
    public function getBody(): ?array
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @return Response
     * @throws ApiHttpException
     */
    abstract public function get(): Response;

    /**
     * @return Response
     * @throws ApiHttpException
     */
    abstract public function post(): Response;

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters ?? [];
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getCacheKey(): string
    {
        return hash('sha256', sprintf('%s-%s-%s-%s', $this->base, $this->token, $this->uri, json_encode($this->parameters, JSON_THROW_ON_ERROR, 512)));
    }


    /**
     * @return array
     * @throws ApiException
     * @throws GuzzleException
     */
    protected function authenticatedGet(): array
    {
        // TODO implement some kind of cache?

        return $this->freshAuthenticatedGet();
    }

    /**
     * @return array
     * @throws ApiException
     * @throws GuzzleException
     */
    protected function authenticatedPost(): array
    {
        $fullUri = sprintf('%s/api/v1/%s', $this->getBase(), $this->getUri());
        if (null !== $this->parameters) {
            $fullUri = sprintf('%s?%s', $fullUri, http_build_query($this->parameters));
        }
        $client  = $this->getClient();
        $options = [
            'headers'    => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->getToken()),
            ],
            'exceptions' => false,
            'body'       => (string)json_encode($this->getBody(), JSON_THROW_ON_ERROR, 512),
        ];

        $debugOpt = $options;
        unset($debugOpt['body']);

        $res = $client->request('POST', $fullUri, $options);

        if (422 === $res->getStatusCode()) {
            $body = (string)$res->getBody();
            $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

            if (null === $json) {
                throw new ApiException(sprintf('Body is empty. Status code is %d.', $res->getStatusCode()));
            }

            return $json;
        }
        if (200 !== $res->getStatusCode()) {
            throw new ApiException(sprintf('Status code is %d: %s', $res->getStatusCode(), (string)$res->getBody()));
        }

        $body = (string)$res->getBody();
        $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if (null === $json) {
            throw new ApiException(sprintf('Body is empty. Status code is %d.', $res->getStatusCode()));
        }

        return $json;
    }


    /**
     * @return array
     * @throws ApiException
     */
    private function freshAuthenticatedGet(): array
    {
        $fullUri = sprintf('%s/api/v1/%s', $this->getBase(), $this->getUri());
        if (null !== $this->parameters) {
            $fullUri = sprintf('%s?%s', $fullUri, http_build_query($this->parameters));
        }

        $client = $this->getClient();
        try {
            $res = $client->request(
                'GET', $fullUri, [
                         'headers' => [
                             'Accept'        => 'application/json',
                             'Authorization' => sprintf('Bearer %s', $this->getToken()),
                         ],
                     ]
            );
        } catch (Exception $e) {
            throw new ApiException(sprintf('GuzzleException: %s', $e->getMessage()));
        }
        if (200 !== $res->getStatusCode()) {
            throw new ApiException(sprintf('Error accessing %s. Status code is %d. Body is: %s', $fullUri, $res->getStatusCode(), (string) $res->getBody()));
        }

        $body = (string) $res->getBody();
        $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if (null === $json) {
            throw new ApiException(sprintf('Body is empty. Status code is %d.', $res->getStatusCode()));
        }

        return $json;
    }

    /**
     * @return mixed
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * @param mixed $base
     */
    public function setBase($base): void
    {
        $this->base = $base;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return Client
     */
    private function getClient(): Client
    {
        // config here


        return new Client;
    }


}
