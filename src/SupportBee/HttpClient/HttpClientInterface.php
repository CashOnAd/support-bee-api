<?php

namespace SupportBee\HttpClient;

/**
 * Description of HttpClientInterface
 *
 * @author deepak
 */
interface HttpClientInterface {

    /**
     * Send a GET request
     *
     * @param string $path       Request path
     * @param array  $parameters GET Parameters
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array Data
     */
    public function get($path, array $parameters = array(), array $headers = array());

    /**
     * Send a POST request
     *
     * @param string $path       Request path
     * @param mixed  $body       Request body
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array Data
     */
    public function post($path, $body = null, array $headers = array());

    /**
     * Send a PUT request
     *
     * @param string $path       Request path
     * @param mixed  $body       Request body
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array Data
     */
    public function put($path, $body, array $headers = array());

    /**
     * Send a DELETE request
     *
     * @param string $path       Request path
     * @param mixed  $body       Request body
     * @param array  $headers    Reconfigure the request headers for this call only
     *
     * @return array Data
     */
    public function delete($path, $body = null, array $headers = array());

    /**
     * Set HTTP headers
     *
     * @param array $headers
     */
    public function setHeaders(array $headers);

    /**
     * Send a request to the server, receive a response,
     * decode the response and returns an associative array
     *
     * @param string $path       Request path
     * @param mixed  $body       Request body
     * @param string $httpMethod HTTP method to use
     * @param array  $headers    Request headers
     *
     * @return array Data
     */
    public function request($path, $body, $httpMethod = 'GET', array $headers = array());
}
