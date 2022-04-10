<?php

declare(strict_types=1);
/**
 * PostTransactionResponse.php
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

namespace GrumpyDictator\FFIIIApiSupport\Response;

use GrumpyDictator\FFIIIApiSupport\Model\TransactionGroup;

/**
 * Class PostTransactionResponse.
 */
class PostTransactionResponse extends Response
{
    private ?TransactionGroup $transactionGroup;
    private array             $rawData;

    /**
     * Response constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->transactionGroup = null;
        if (isset($data['id'])) {
            $this->transactionGroup = TransactionGroup::fromArray($data);
        }
        $this->rawData = $data;
    }

    /**
     * @return array
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    /**
     * @return TransactionGroup|null
     */
    public function getTransactionGroup(): ?TransactionGroup
    {
        return $this->transactionGroup;
    }
}
