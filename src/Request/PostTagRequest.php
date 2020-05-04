<?php
declare(strict_types=1);


namespace GrumpyDictator\FFIIIApiSupport\Request;

use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiException;
use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\PostTransactionResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GrumpyDictator\FFIIIApiSupport\Response\ValidationErrorResponse;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class PostTagRequest
 */
class PostTagRequest extends Request
{

    /**
     * PostTagRequest constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('tags');
    }

    /**
     * @inheritDoc
     */
    public function get(): Response
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function put(): Response
    {
        // TODO: Implement put() method.
    }

    /**
     * @inheritDoc
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
