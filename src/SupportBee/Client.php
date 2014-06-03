<?php

namespace SupportBee;

use SupportBee\Api\ApiInterface;
use SupportBee\Api\Labels;
use SupportBee\Api\Tickets;
use SupportBee\Exception\InvalidArgumentException;
use SupportBee\HttpClient\HttpClient;
use SupportBee\HttpClient\HttpClientInterface;

/**
 * Description of Client
 *
 * @author deepak
 */
class Client {

    const AUTH_TOKEN = 'rymnBM29yFaQCMdhfNpi';

    /**
     * @var array
     */
    private $options = array(
        'base_url' => 'https://fireflies.supportbee.com',
    );

    /**
     * The instance used to communicate with SupportBee
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Instantiate a new SupportBee client
     *
     * @param null|HttpClientInterface $httpClient Github http client
     */
    public function __construct(HttpClientInterface $httpClient = null) {
        $this->httpClient = $httpClient;
    }

    /**
     *
     * @param string $name
     * @return ApiInterface
     * @throws InvalidArgumentException
     */
    public function api($name) {
        switch ($name) {
            case 'tickets':
                $api = new Tickets($this);
                break;

            case 'labels':
                $api = new Labels($this);
                break;

            default :
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
        return $api;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient() {
        if (null === $this->httpClient) {
            $this->httpClient = new HttpClient($this->options);
        }

        return $this->httpClient;
    }

    /**
     * @param HttpClientInterface $httpClient
     */
    public function setHttpClient(HttpClientInterface $httpClient) {
        $this->httpClient = $httpClient;
    }

    /**
     * Clears used headers
     */
    public function clearHeaders() {
        $this->getHttpClient()->clearHeaders();
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers) {
        $this->getHttpClient()->setHeaders($headers);
    }

}
