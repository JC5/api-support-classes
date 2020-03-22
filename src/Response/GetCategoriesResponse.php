<?php

declare(strict_types=1);
/**
 * GetCategoriesResponse.php
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

use Countable;
use GrumpyDictator\FFIIIApiSupport\Model\Category;
use Illuminate\Support\Collection;
use Iterator;

/**
 * Class GetCategoriesResponse.
 */
class GetCategoriesResponse extends Response implements Iterator, Countable
{
    /** @var Collection */
    private $collection;
    /** @var int */
    private $position = 0;

    /**
     * Response constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->collection = new Collection;

        /** @var array $row */
        foreach ($data as $row) {
            $model = Category::fromArray($row);
            $this->collection->push($model);
        }
    }

    /**
     * Count elements of an object.
     *
     * @link  https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count(): int
    {
        return $this->collection->count();
    }

    /**
     * Return the current element.
     *
     * @link  https://php.net/manual/en/iterator.current.php
     * @return Category
     * @since 5.0.0
     */
    public function current(): Category
    {
        return $this->collection->get($this->position);
    }

    /**
     * Return the key of the current element.
     *
     * @link  https://php.net/manual/en/iterator.key.php
     * @return int
     * @since 5.0.0
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Move forward to next element.
     *
     * @link  https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next(): void
    {
        $this->position++;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @link  https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Checks if current position is valid.
     *
     * @link  https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid(): bool
    {
        return $this->collection->has($this->position);
    }
}
