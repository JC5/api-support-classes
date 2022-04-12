<?php

declare(strict_types=1);

namespace GrumpyDictator\FFIIIApiSupport\Request;

use GrumpyDictator\FFIIIApiSupport\Response\PostTagResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;
use GrumpyDictator\FFIIIApiSupport\Response\ValidationErrorResponse;

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
     */
    public function __construct(string $url, string $token)
    {
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
        $data = $this->authenticatedPost();
        if (array_key_exists('errors', $data) && is_array($data['errors']) ) {
            return new ValidationErrorResponse($data['errors']);
        }
        if(!array_key_exists('data', $data)) {
            // should be impossible to get here (see previous code) but still check.
            if (array_key_exists('errors', $data) && is_array($data['errors']) ) {
                return new ValidationErrorResponse($data['errors']);
            }
            // no data array and no error info, that's weird!
            if(!array_key_exists('errors', $data)) {
                $info = [
                    'unknown_field' => [sprintf('Unknown error: %s', json_encode($data, 0, 16))]
                ];
                return new ValidationErrorResponse($info);
            }
        }
        return new PostTagResponse($data['data'] ?? []);
    }
}
