<?php

namespace SupportBee\HttpClient\Message;

use Guzzle\Http\Message\Response;

/**
 * Description of ResponseMediator
 *
 * @author deepak
 */
class ResponseMediator {

    public static function getContent(Response $response) {
        $body = $response->getBody(true);
        $content = json_decode($body);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $body;
        }

        return $content;
    }

    public static function getPagination(Response $response) {
        $header = $response->getHeader('Link');

        if (empty($header)) {
            return null;
        }

        $pagination = array();
        foreach (explode(',', $header) as $link) {
            preg_match('/<(.*)>; rel="(.*)"/i', trim($link, ','), $match);

            if (3 === count($match)) {
                $pagination[$match[2]] = $match[1];
            }
        }

        return $pagination;
    }

}
