<?php

declare(strict_types=1);
/**
 * Transaction.php
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

namespace GrumpyDictator\FFIIIApiSupport\Model;

/**
 * Class Transaction.
 */
class Transaction
{
    /**
     * @var string 
     */
    public $amount;
    /**
     * @var string 
     */
    public $currencyCode;
    /**
     * @var int 
     */
    public $currencyDecimalPlaces;
    /**
     * @var int 
     */
    public $currencyId;
    /**
     * @var string 
     */
    public $date;
    /**
     * @var string 
     */
    public $description;
    /**
     * @var int 
     */
    public $id;
    /**
     * @var string 
     */
    public $type;
    /**
     * @var Tag[] 
     */
    public $tags;
    /**
     * @var string 
     */
    public $destinationName;

    /**
     * Transaction constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id                    = (int) $data['transaction_journal_id'] ?? -1;
        $this->description           = $data['description'] ?? null;
        $this->destinationName       = $data['destination_name'] ?? null;
        $this->type                  = $data['type'] ?? null;
        $this->date                  = $data['date'] ?? null;
        $this->amount                = $data['amount'] ?? null;
        $this->currencyCode          = $data['currency_code'] ?? null;
        $this->currencyId            = $data['currency_id'] ?? null;
        $this->currencyDecimalPlaces = $data['currency_decimal_places'] ?? null;
        $this->tags                  = $data['tags'] ?? [];
    }
}
