<?php

namespace SupportBee;

/**
 * Description of Client
 *
 * @author deepak
 */
use Guzzle\Http\Client;

class SupportBeeClient {

    /**
     *
     * @param string $domain
     * @param string $authkey
     */
    public function __construct($domain, $apiKey) {
        $this->api_key = $apiKey;

        //Check if domain name include supportbee.com or not
        if (strpos($domain, '.') === false) {
            $this->base = 'https://' . $domain . '.supportbee.com';
        } else {
            $this->base = 'https://' . $domain;
        }
    }

    /**
     *
     * @param string $url
     * @param array $data=array() An associative array of parameters
     * @param string $action for Actions like GET/POST/DELETE
     */
    public function call($url, $data, $action) {

        //Create HTTP Client
        $client = new Client($this->base, array(
            'request.options' => array(
                'headers' => array(
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ),
            )
                )
        );

        switch ($action) {
            case "POST":
                if ($url == '/tickets') {
                    $request = $client->post($url, array(), $data);
                } else {
                    $request = $client->post($url . '?auth_token=' . $this->api_key, array(), $data);
                }
                break;
            case "GET":
                $request = $client->get($url . '?auth_token=' . $this->api_key, $data);
                break;
            case "PUT":
                $request = $client->put($url . '?auth_token=' . $this->api_key, $data);
                break;
            case "DELETE":
                $request = $client->delete($url . '?auth_token=' . $this->api_key, $data);
                break;
            default :
                break;
        }
        $response = $request->send();
        return $response;
    }

    /**
     *
     * @param string $subject for trouble ticket
     * @param string $requester_name
     * @param email $requester_email
     * @param array $cc
     * @param text $text
     * @param text $html
     * @param array $attachments contains ids of attached files
     * @return type
     */
    public function submitTicket($subject, $requester_name, $requester_email, $cc, $text, $html, $attachments) {
        $data_array = array('ticket' => array(
                'subject' => $subject,
                'requester_name' => $requester_name,
                'requester_email' => $requester_email,
                'cc' => $cc,
                'content' => array(
                    'text' => $text,
                    'html' => $html,
                    'attachments_ids' => $attachments
                )
        ));
        $data = json_encode($data_array);
        return $this->call('/tickets', $data, 'POST');
    }

    /**
     *
     * @return json Provides list of all tickets
     */
    public function getAllTickets() {
        return $this->call('/tickets', '', 'GET');
    }

    public function getTicketsByOption($option) {
        return $this->call('/tickets' . $option, '', 'GET');
    }

    /**
     *
     * @return json Provides list of avaliable labels
     */
    public function getLabels() {
        return $this->call('/labels', '', 'GET');
    }

}
