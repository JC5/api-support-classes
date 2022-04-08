<?php

declare(strict_types=1);
/**
 * Bill.php
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
 * Class Bill.
 */
class Bill
{
    /** @var int */
    public $id;
    /** @var string */
    public $name;

    /** @var string */
    public $repeat_freq;

    /**
     * Account constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @param array $array
     *
     * @return static
     */
    public static function fromArray(array $array): self
    {
        $bill = new self;

        $bill->id          = (int) $array['id'] ?? -1;
        $bill->name        = $array['attributes']['name'] ?? null;
        $bill->repeat_freq = $array['attributes']['repeat_freq'] ?? null;

        return $bill;
    }
}
