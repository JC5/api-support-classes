<?php

declare(strict_types=1);
/**
 * PostTransactionRequest.php
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
use GrumpyDictator\FFIIIApiSupport\Response\PostTransactionResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GrumpyDictator\FFIIIApiSupport\Response\ValidationErrorResponse;

/**
 * Class PostTransactionRequest
 * POST a transaction.
 */
class PostTransactionRequest extends Request
{
    /**
     * PostTransactionRequest constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('transactions');
    }

    /**
     * @return Response
     */
    public function get(): Response
    {
        // TODO: Implement get() method.
    }

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function post(): Response
    {
        $data = $this->authenticatedPost();
        if (array_key_exists('errors', $data) && is_array($data['errors']) ) {
            return new ValidationErrorResponse($data['errors']);
        }
        if(!array_key_exists('data', $data)) {
            // should be impossible to get here (see previous code) but still check.
            if (array_key_exists('errors', $data) && is_array($data['errors']) ) {
                return new ValidationErrorResponse($data['errors']);
            }
            // no data array and no error info, that's weird!
            if(!array_key_exists('errors', $data)) {
                $info = [
                    'unknown_field' => [sprintf('Unknown error: %s', json_encode($data, 0, 16))]
                ];
                return new ValidationErrorResponse($info);
            }
        }
        return new PostTransactionResponse($data['data'] ?? []);
    }

    /**
     * {@inheritdoc}
     */
    public function put(): Response
    {
        // TODO: Implement put() method.
    }
}
