<?php

namespace GrumpyDictator\FFIIIApiSupport\Request;

use GrumpyDictator\FFIIIApiSupport\Exceptions\ApiHttpException;
use GrumpyDictator\FFIIIApiSupport\Response\PostFinishBatchResponse;
use GrumpyDictator\FFIIIApiSupport\Response\Response;

class PostFinishBatchRequest extends Request
{

    public function __construct(string $url, string $token, bool $applyRules)
    {
        $this->setBase($url);
        $this->setToken($token);
        $this->setUri('batch/finish');
        $this->setParameters(['apply_rules' => $applyRules ? 'true' : 'false']);
    }

    public function delete(): Response {}

    /**
     * @return Response
     * @throws ApiHttpException
     */
    public function get(): Response {}

    /**
     * @return Response
     */
    public function post(): Response
    {
        $parameters = $this->getParameters();
        $this->setParameters($parameters);
        $data = $this->authenticatedPost();
        return new PostFinishBatchResponse($data);
    }

    /**
     * {@inheritdoc}
     */
    public function put(): Response {}
}
