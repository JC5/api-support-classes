<?php

declare(strict_types=1);
/**
 * AccountType.php
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
 * Class AccountType.
 */
class AccountType
{
    /** @var string */
    public const ASSET = 'asset';

    /** @var string */
    public const CASH = 'cash';

    /** @var string */
    public const DEBT = 'debt';

    /** @var string */
    public const LOAN = 'loan';

    /** @var string */
    public const EXPENSE = 'expense';

    /** @var string */
    public const INITIAL_BALANCE = 'initial balance';

    /** @var string */
    public const MORTGAGE = 'mortgage';

    /** @var string */
    public const RECONCILIATION = 'reconciliation';

    /** @var string */
    public const REVENUE = 'revenue';

    public const LIABILITIES = 'liabilities';
}
