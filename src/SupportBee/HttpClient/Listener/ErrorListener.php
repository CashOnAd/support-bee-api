<?php

namespace SupportBee\HttpClient\Listener;

use SupportBee\HttpClient\Message\ResponseMediator;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Response;
use SupportBee\Exception\ErrorException;
use SupportBee\Exception\RuntimeException;
use SupportBee\Exception\ValidationFailedException;

/**
 * @author deepak
 */
class ErrorListener {

    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options) {
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function onRequestError(Event $event) {
        /** @var $request \Guzzle\Http\Message\Request */
        $request = $event['request'];
        $response = $request->getResponse();

        if ($response->isClientError() || $response->isServerError()) {

            $content = ResponseMediator::getContent($response);
            if (is_array($content) && isset($content->error)) {
                if (400 == $response->getStatusCode()) {
                    throw new ErrorException($content->error, 400);
                } elseif (422 == $response->getStatusCode() && isset($content->error)) {
                    $errors = array();
                    foreach ($content->error as $error) {
                        switch ($error['code']) {
                            case 'missing':
                                $errors[] = sprintf('The %s %s does not exist, for resource "%s"', $error['field'], $error['value'], $error['resource']);
                                break;

                            case 'missing_field':
                                $errors[] = sprintf('Field "%s" is missing, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            case 'invalid':
                                $errors[] = sprintf('Field "%s" is invalid, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            case 'already_exists':
                                $errors[] = sprintf('Field "%s" already exists, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            default:
                                $errors[] = $error['message'];
                                break;
                        }
                    }

                    throw new ValidationFailedException('Validation Failed: ' . implode(', ', $errors), 422);
                }
            }

            throw new RuntimeException(isset($content->error) ? $content->error : $content, $response->getStatusCode());
        };
    }

}
