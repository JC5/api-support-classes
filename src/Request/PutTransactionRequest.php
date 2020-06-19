<?php

declare(strict_types=1);

namespace GrumpyDictator\FFIIIApiSupport\Request;

use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiException;
use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\PostTransactionResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class PutTransactionRequest.
 */
class PutTransactionRequest extends Request
{
    /** @var int */
    private $groupId;

    /**
     * PutTransactionRequest constructor.
     *
     * @param string $url
     * @param string $token
     * @param int    $groupId
     * @param string|null $trustedCertPath (optional) path to trusted (self-signed) certificate
     */
    public function __construct(string $url, string $token, int $groupId, string $trustedCertPath = null)
    {
        parent::__construct($trustedCertPath);
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri(sprintf('transactions/%d', $groupId));
        $this->groupId = $groupId;
    }

    /**
     * {@inheritdoc}
     */
    public function get(): Response
    {
        // TODO: Implement get() method.
    }

    /**
     * {@inheritdoc}
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
        try {
            $data = $this->authenticatedPut();
        } catch (ApiException | GuzzleException $e) {
            throw new ApiHttpException($e->getMessage());
        }

        return new PostTransactionResponse($data['data']);
    }
}
