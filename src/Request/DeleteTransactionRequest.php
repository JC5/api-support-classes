<?php

declare(strict_types=1);

namespace GrumpyDictator\FFIIIApiSupport\Request;

use GrumpyDictator\FFIIIApiSupport\Response\Response;

/**
 * Class PutTransactionRequest.
 */
class DeleteTransactionRequest extends Request
{
    private int $groupId;

    /**
     * PutTransactionRequest constructor.
     *
     * @param string $url
     * @param string $token
     * @param int    $groupId
     */
    public function __construct(string $url, string $token, int $groupId)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri(sprintf('transactions/%d', $groupId));
        $this->groupId = $groupId;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): Response {}

    /**
     * {@inheritdoc}
     */
    public function post(): Response {}

    /**
     * {@inheritdoc}
     */
    public function put(): Response {}

    public function delete(): Response
    {
        return new DeleteTransactionResponse($this->authenticatedDelete());
    }
}
