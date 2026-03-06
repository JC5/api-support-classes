<?php

namespace GrumpyDictator\FFIIIApiSupport\Response;

class GetCountTransactionsResponse extends Response
{
    private int $count = 0;

    /**
     * Response constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->count = $data['count'];
    }

    public function getCount(): int
    {
        return $this->count;
    }


}