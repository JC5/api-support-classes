<?php

declare(strict_types=1);
/**
 * GetTransactionsRequest.php
 * Copyright (c) 2023 james@firefly-iii.org.
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
use GrumpyDictator\FFIIIApiSupport\Response\GetTransactionsResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;

/**
 * Class GetSearchTransactionsRequest.
 */
class GetTransactionsRequest extends Request
{

    /**
     * GetSearchAccountRequest constructor.
     *
     * @param  string  $url
     * @param  string  $token
     */
    public function __construct(string $url, string $token)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('transactions');
    }

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function get(): Response
    {
        $collectedRows = [];
        $hasNextPage   = true;
        $loopCount     = 0;
        $page          = 1;

        while ($hasNextPage && $loopCount < 30) {
            $parameters         = $this->getParameters();
            $parameters['page'] = $page;
            $this->setParameters($parameters);
            $data            = $this->authenticatedGet();
            $collectedRows[] = $data['data'];
            $totalPages      = $data['meta']['pagination']['total_pages'] ?? 1;
            if ($page < $totalPages) {
                $page++;
                $loopCount++;
                continue;
            }
            $hasNextPage = false;
        }

        return new GetTransactionsResponse(array_merge(...$collectedRows));
    }


    /**
     * @param  string  $query
     */
    public function setFilter(string $start, string $end, string $type): void
    {
        $this->setParameters(['start' => $start, 'end' => $end, 'type' => $type]);
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
     */
    public function post(): Response
    {
        // TODO: Implement post() method.
    }
}
