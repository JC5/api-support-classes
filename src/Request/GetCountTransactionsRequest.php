<?php

declare(strict_types=1);
/**
 * GetSearchTransactionsRequest.php
 * Copyright (c) 2021 james@firefly-iii.org.
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

use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\GetCountTransactionsResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;

/**
 * Class GetSearchTransactionsRequest.
 */
class GetCountTransactionsRequest extends Request
{
    private string $externalIdentifier = '';
    private string $internalReference  = '';
    private string $notes              = '';
    private string $description        = '';
    private bool   $includeDeleted     = true;

    public function __construct(string $url, string $token)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('search/transactions/count');
    }

    public function setExternalIdentifier(string $externalIdentifier): void
    {
        $this->externalIdentifier = $externalIdentifier;
    }

    public function setInternalReference(string $internalReference): void
    {
        $this->internalReference = $internalReference;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setIncludeDeleted(bool $includeDeleted): void
    {
        $this->includeDeleted = $includeDeleted;
    }

    /**
     * GetSearchAccountRequest constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function delete(): Response {}

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function get(): Response
    {
        $params = [
            'include_deleted' => true === $this->includeDeleted ? 'true' : 'false',
        ];
        if ('' !== $this->externalIdentifier) {
            $params['external_identifier'] = $this->externalIdentifier;
        }
        if ('' !== $this->internalReference) {
            $params['internal_identifier'] = $this->internalReference;
        }
        if ('' !== $this->notes) {
            $params['notes'] = $this->notes;
        }
        if ('' !== $this->description) {
            $params['description'] = $this->description;
        }
        $this->setParameters($params);
        $data = $this->authenticatedGet();

        return new GetCountTransactionsResponse($data);
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
        $this->setParameters(['query' => $query]);
    }

    /**
     * @return Response
     */
    public function post(): Response
    {
        // TODO: Implement post() method.
    }

    /**
     * {@inheritdoc}
     */
    public function put(): Response
    {
        // TODO: Implement put() method.
    }
}
