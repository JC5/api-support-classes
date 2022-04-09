<?php

declare(strict_types=1);
/**
 * GetAccountRequest.php
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

use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\GetAccountResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;

/**
 * Class GetAccountRequest.
 *
 * Returns a single account.
 */
class GetAccountRequest extends Request
{
    private int $id;

    /**
     * GetAccountsRequest constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('accounts');
    }

    /**
     * {@inheritdoc}
     */
    public function put(): Response
    {
        // TODO: Implement put() method.
    }

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function get(): Response
    {
        $data = $this->authenticatedGet();

        return new GetAccountResponse($data['data']);
    }

    /**
     * @return Response
     */
    public function post(): Response
    {
        // TODO: Implement post() method.
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
        $this->setUri(sprintf('accounts/%d', $id));
    }
}
