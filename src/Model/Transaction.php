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
    /** @var string */
    public $amount;
    /** @var string */
    public $currencyCode;
    /** @var int */
    public $currencyDecimalPlaces;
    /** @var int */
    public $currencyId;
    /** @var string */
    public $date;
    /** @var string */
    public $description;
    /** @var int */
    public $id;
    /** @var string */
    public $type;

    /**
     * Transaction constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id                    = (int) $data['transaction_journal_id'];
        $this->description           = $data['description'];
        $this->type                  = $data['type'];
        $this->date                  = $data['date'];
        $this->amount                = $data['amount'];
        $this->currencyCode          = $data['currency_code'];
        $this->currencyId            = $data['currency_id'];
        $this->currencyDecimalPlaces = $data['currency_decimal_places'];
    }
}
