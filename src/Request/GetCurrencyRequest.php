<?php

declare(strict_types=1);
/**
 * GetCurrencyRequest.php
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
use GrumpyDictator\FFIIIApiSupport\Response\GetCurrencyResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;

/**
 * Class GetCurrencyRequest.
 *
 * Gets a single currency.
 */
class GetCurrencyRequest extends Request
{
    private string $code;

    /**
     * GetCurrenciesRequest constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('currencies');
    }

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function get(): Response
    {
        $data = $this->authenticatedGet();

        return new GetCurrencyResponse($data['data']);
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

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
        $this->setUri(sprintf('currencies/%s', $code));
    }
}
