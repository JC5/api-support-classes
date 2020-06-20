<?php

declare(strict_types=1);

namespace GrumpyDictator\FFIIIApiSupport\Request;

use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiException;
use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\PostTagResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GrumpyDictator\FFIIIApiSupport\Response\ValidationErrorResponse;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class PostTagRequest.
 */
class PostTagRequest extends Request
{
    /**
     * PostTagRequest constructor.
     *
     * @param string $url
     * @param string $token
     * @param string|null $trustedCertPath (optional) path to trusted (self-signed) certificate
     */
    public function __construct(string $url, string $token, string $trustedCertPath = null)
    {
        $this->trustedCertPath = $trustedCertPath;
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('tags');
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
    public function put(): Response
    {
        // TODO: Implement put() method.
    }

    /**
     * {@inheritdoc}
     */
    public function post(): Response
    {
        try {
            $data = $this->authenticatedPost();
        } catch (ApiException | GuzzleException $e) {
            throw new ApiHttpException($e->getMessage());
        }
        if (isset($data['message']) && self::VALIDATION_ERROR_MSG === $data['message']) {
            return new ValidationErrorResponse($data['errors']);
        }

        return new PostTagResponse($data['data']);
    }
}
