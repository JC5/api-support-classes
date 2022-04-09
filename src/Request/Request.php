<?php

declare(strict_types=1);
/**
 * Request.php
 * Copyright (c) 2020 james@firefly-iii.org.
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
use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

/**
 * Class Request.
 */
abstract class Request
{
    protected const VALIDATION_ERROR_MSG     = 'The given data was invalid.';
    protected const VALIDATION_DUPLICATE_MSG = 'Duplicate of transaction #';
    private string $base = '';
    private array  $body = [];
    private array  $parameters = [];
    private string $token = '';
    private string $uri = '';
    private bool   $verify  = true;
    private float  $timeOut = 3.14;

    /**
     * @param bool $verify
     */
    public function setVerify(bool $verify): void
    {
        $this->verify = $verify;
    }

    /**
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @param float $timeOut
     */
    public function setTimeOut(float $timeOut): void
    {
        $this->timeOut = $timeOut;
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
    abstract public function put(): Response;

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
     * @return array|null
     */
    public function getBody(): ?array
    {
        return $this->body;
    }

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
     * @return Response
     * @throws ApiHttpException
     */
    abstract public function post(): Response;

    /**
     * @return array
     * @throws ApiHttpException
     */
    protected function authenticatedGet(): array
    {
        $fullUri = sprintf('%s/api/v1/%s', $this->getBase(), $this->getUri());
        if (null !== $this->parameters) {
            $fullUri = sprintf('%s?%s', $fullUri, http_build_query($this->parameters));
        }

        $client  = $this->getClient();
        $options = [
            'http_errors' => false,
            'headers'     => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->getToken()),
            ],
        ];

        // loop 5 times just in case.
        $success = false;
        $loop    = 0;
        $res     = null;
        /** @var Exception $lastError */
        $lastError = null;
        while (false === $success && $loop < 5) {
            try {
                $res = $client->request('GET', $fullUri, $options);
            } catch (GuzzleException $e) {
                $this->handleException($e);
                $lastError = $e;
            }
            $success = true;
            $loop++;
        }
        if ((5 === $loop && false === $success) || null === $res) {
            $lastErrorMessage = null !== $lastError ? $lastError->getMessage() : 'Unknown error.';
            throw new ApiHttpException(sprintf('Tried "%s" 5 times but failed: %s', $fullUri, $lastErrorMessage));
        }

        if (200 !== $res->getStatusCode()) {
            throw new ApiHttpException(sprintf('Error accessing "%s". Status code is %d. Body is: %s', $fullUri, $res->getStatusCode(), (string) $res->getBody()));
        }

        $body = (string) $res->getBody();
        try {
            $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ApiHttpException(sprintf('Could not decode JSON from URL "%s": %s', $fullUri, $e->getMessage()));
        }

        if (null === $json) {
            throw new ApiHttpException(sprintf('Body is empty. Status code is %d.', $res->getStatusCode()));
        }

        return $json;
    }

    /**
     * @return array
     * @throws ApiHttpException
     */
    protected function authenticatedPost(): array
    {
        return $this->authenticatedSubmission('POST');
    }

    /**
     * @return array
     * @throws ApiHttpException
     */
    protected function authenticatedPut(): array
    {
        return $this->authenticatedSubmission('PUT');
    }

    /**
     * @param string $method
     * @return array
     * @throws ApiHttpException
     */
    private function authenticatedSubmission(string $method): array
    {
        $fullURL = sprintf('%s/api/v1/%s', $this->getBase(), $this->getUri());
        if (null !== $this->parameters) {
            $fullURL = sprintf('%s?%s', $fullURL, http_build_query($this->parameters));
        }
        $client = $this->getClient();
        try {
            $options = [
                'http_errors' => false,
                'headers'     => [
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                    'Authorization' => sprintf('Bearer %s', $this->getToken()),
                ],
                'exceptions'  => false,
                'body'        => (string) json_encode($this->getBody(), JSON_THROW_ON_ERROR),
            ];
        } catch (JsonException $e) {
            throw new ApiHttpException(sprintf('Could not encode JSON body for "%s"', $fullUri));
        }

        // loop 5 times just in case.
        $success = false;
        $loop    = 0;
        $res     = null;
        /** @var Exception $lastError */
        $lastError = null;
        while (false === $success && $loop < 5) {
            try {
                $res = $client->request($method, $fullURL, $options);
            } catch (GuzzleException $e) {
                $this->handleException($e);
                $lastError = $e;
            }
            $success = true;
            $loop++;
        }
        if ((5 === $loop && false === $success) || null === $res) {
            $lastErrorMessage = null !== $lastError ? $lastError->getMessage() : 'Unknown error.';
            throw new ApiHttpException(sprintf('Tried "%s" 5 times but failed: %s', $fullURL, $lastErrorMessage));
        }

        if (422 === $res->getStatusCode()) {
            $body = (string) $res->getBody();
            try {
                $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new ApiHttpException(sprintf('Could not decode JSON body for "%s"', $fullUri));
            }

            if (null === $json) {
                throw new ApiHttpException(sprintf('Body is empty. Status code is %d.', $res->getStatusCode()));
            }

            return $json;
        }

        if (200 !== $res->getStatusCode()) {
            throw new ApiHttpException(sprintf('Status code is %d: %s', $res->getStatusCode(), (string) $res->getBody()));
        }

        $body = (string) $res->getBody();

        try {
            $json = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new ApiHttpException(sprintf('Could not decode JSON from URL "%s": %s', $fullURL, $e->getMessage()));
        }

        if (null === $json) {
            throw new ApiHttpException(sprintf('Body is empty. Status code is %d.', $res->getStatusCode()));
        }

        return $json;
    }


    /**
     * @return Client
     */
    private function getClient(): Client
    {
        $opts = [
            'verify'          => $this->verify,
            'connect_timeout' => $this->timeOut,
        ];
        return new Client($opts);
    }

    /**
     * @param GuzzleException $e
     * @throws ApiHttpException
     */
    private function handleException(GuzzleException $e): void
    {
        $message = $e->getMessage();
        if (str_contains($message, 'cURL error 28')) {
            // don't respond to time out, let it try again.
            return;
        }
        throw new ApiHttpException($e->getMessage());
    }
}
