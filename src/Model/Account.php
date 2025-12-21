<?php

declare(strict_types=1);
/**
 * Account.php
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
 * Class Account.
 */
class Account
{
    public ?string $bic;
    public ?string $currencyCode;
    public ?string $iban;
    public int     $id;
    public ?string $name;
    public ?string $number;
    public ?string $accountNumber;
    public ?string $type;

    public ?string $currentBalance;
    public ?string $currentBalanceDate;

    /**
     * @param array $array
     *
     * @return static
     */
    public static function fromArray(array $array): self
    {
        $account     = new self;
        $account->id = (int)$array['id'];
        if (array_key_exists('attributes', $array)) {
            $account->name               = $array['attributes']['name'];
            $account->type               = $array['attributes']['type'];
            $account->iban               = $array['attributes']['iban'];
            $account->number             = $array['attributes']['account_number'];
            $account->accountNumber      = $array['attributes']['account_number'];
            $account->bic                = $array['attributes']['bic'];
            $account->currencyCode       = $array['attributes']['currency_code'];
            $account->currentBalance     = $array['attributes']['current_balance'];
            $account->currentBalanceDate = $array['attributes']['current_balance_date'];
            return $account;
        }

        $account->name               = $array['name'];
        $account->type               = $array['type'];
        $account->iban               = $array['iban'];
        $account->number             = $array['account_number'];
        $account->accountNumber      = $array['account_number'];
        $account->bic                = $array['bic'];
        $account->currencyCode       = $array['currency_code'];
        $account->currentBalance     = $array['current_balance'];
        $account->currentBalanceDate = $array['current_balance_date'];

        return $account;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'type'                 => $this->type,
            'iban'                 => $this->iban,
            'account_number'       => $this->accountNumber,
            'bic'                  => $this->bic,
            'currency_code'        => $this->currencyCode,
            'current_balance'      => $this->currentBalance,
            'current_balance_date' => $this->currentBalanceDate,
        ];
    }
}
