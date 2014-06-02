<?php

namespace SupportBee\HttpClient;

use Guzzle\Http\Client as GuzzleClient;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use LogicException;
use SupportBee\Client;
use SupportBee\Exception\ErrorException;
use SupportBee\Exception\RuntimeException;
use SupportBee\HttpClient\Listener\ErrorListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of HttpClient
 *
 * @author deepak
 */
class HttpClient implements HttpClientInterface {

    protected $options = array(
        'base_url' => 'https://fireflies.supportbee.com/',
        'header_type' => 'application/json'
    );
    protected $headers = array(
        'Content-Type' => 'application/json',
        'Accept' => 'application/json'
    );

    /**
     * @param array           $options
     * @param ClientInterface $client
     */
    public function __construct(array $options = array(), ClientInterface $client = null) {
        $this->options = array_merge($this->options, $options);
        $client = $client ? : new GuzzleClient($this->options['base_url'], $this->options);
        $this->client = $client;

        $this->addListener('request.error', array(new ErrorListener($this->options), 'onRequestError'));
        $this->clearHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers) {
        $this->headers = array_merge($this->headers, $headers);
    }

    /**
     * Clears used headers
     */
    public function clearHeaders() {
        $this->headers = array(
            'Content-Type' => sprintf('%s', $this->options['header_type']),
            'Accept' => sprintf('%s', $this->options['header_type'])
        );
    }

    public function addListener($eventName, $listener) {
        $this->client->getEventDispatcher()->addListener($eventName, $listener);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber) {
        $this->client->addSubscriber($subscriber);
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), array $headers = array()) {
        return $this->request($path, null, 'GET', $headers, array('query' => $parameters));
    }

    /**
     * {@inheritDoc}
     */
    public function post($path, $body = null, array $headers = array()) {
        return $this->request($path, $body, 'POST', $headers);
    }

    /**
     * {@inheritDoc}$remaining = (string) $response->getHeader('X-RateLimit-Remaining');

      if (null != $remaining && 1 > $remaining && 'rate_limit' !== substr($request->getResource(), 1, 10)) {
      throw new ApiLimitExceedException($this->options['api_limit']);
      }
     */
    public function delete($path, $body = null, array $headers = array()) {
        return $this->request($path, $body, 'DELETE', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function put($path, $body, array $headers = array()) {
        return $this->request($path, $body, 'PUT', $headers);
    }

    /**
     * {@inheritDoc}
     */
    public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array()) {
        if ($path == '/tickets' && $httpMethod == 'POST') {
            $path = $this->options['base_url'] . $path;
        } else {
            if (strpos($path, '?') === false) {
                $path = $this->options['base_url'] . $path . '?auth_token=' . Client::AUTH_TOKEN;
            } else {
                $path = $this->options['base_url'] . $path . '&auth_token=' . Client::AUTH_TOKEN;
            }
        }
        $request = $this->createRequest($httpMethod, $path, $body, $headers, $options);
        $request->addHeaders($headers);
        try {
            $response = $this->client->send($request);
        } catch (LogicException $e) {
            throw new ErrorException($e->getMessage());
        } catch (\RuntimeException $e) {
            throw new RuntimeException($e->getMessage());
        }

        return $response;
    }

    protected function createRequest($httpMethod, $path, $body = null, array $headers = array(), array $options = array()) {
        return $this->client->createRequest(
                        $httpMethod, $path, array_merge($this->headers, $headers), $body, $options
        );
    }

}
