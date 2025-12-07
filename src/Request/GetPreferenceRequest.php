<?php

declare(strict_types=1);
/**
 * GetPreferenceRequest.php
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
use GrumpyDictator\FFIIIApiSupport\Response\PreferenceResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;

/**
 * Class GetPreferenceRequest.
 *
 * Returns a single preference.
 */
class GetPreferenceRequest extends Request
{
    private string $name;

    /**
     * GetBudgetsRequest constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->name = '';
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('preferences');
    }

    public function delete(): Response {}

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function get(): Response
    {
        $data = $this->authenticatedGet();

        return new PreferenceResponse($data['data']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
        $this->setUri(sprintf('preferences/%s', $name));
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
