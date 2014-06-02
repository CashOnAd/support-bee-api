<?php

namespace SupportBee\Api;

use SupportBee\Model\Ticket;

/**
 * Description of Tickets
 *
 * @author deepak
 */
class Tickets extends AbstractApi {

    //Create New Support Ticket
    public function createTickets($data) {
        $content = array('ticket' => array(
                'subject' => $data->getSubject(),
                'requester_name' => $data->getRequesterName(),
                'requester_email' => $data->getRequesterEmail(),
                'cc' => array($data->getCc1(), $data->getCc2()),
                'content' => array(
                    'text' => $data->getTextMessage(),
                    'html' => $data->getHtmlMessage(),
                    'attachments_ids' => array()
                )
        ));

        return $this->post('/tickets', $content);
    }

    //Get List of tickets
    public function getTickets($per_page = 20, $page = 1) {
        $data = $this->get('/tickets?per_page=' . (int) $per_page . '&page=' . (int) $page);
        return $data;
//        var_dump($data->tickets);
//
//        foreach ($data->tickets as $ticket) {
//            echo $ticket->subject . '<br/>';
//        }
//
//        die();
//        $response = new Ticket();
//        $response->setCc1($data->total);
//
//        return $response;
    }

    //Show details of specific ticket
    public function showTicket($id) {
        $result = $this->get('/tickets/' . $id);
        $data = $result->ticket;
        $response = new Ticket();
        $response->setSubject($data->subject);
        $response->setLastActivityDate($data->last_activity_at);
        $response->setReceivedDate($data->created_at);
        $response->setTextMessage($data->summary);
        $response->setRequesterName($data->requester->name);
        $response->setRequesterEmail($data->requester->email);

        return $response;
    }

}
