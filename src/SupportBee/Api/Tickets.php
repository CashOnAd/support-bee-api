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
    public function getTickets($per_page = 15, $page = 1) {

        $parameters = array('per_page' => $per_page, 'page' => $page);
        $data = $this->get('/tickets', $parameters);
        return $data;
//        var_dump($data->tickets);
//
//
//        foreach ($data->tickets as $ticket) {
//            echo $ticket->subject . '<br/>';
//        }
//
//        die();
//        $response = new Ticket();
//        $response->setTickets($data->tickets);
////
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

    //Trash Ticket
    public function trashTicket($id) {
        $result = $this->post('/tickets/' . $id . '/trash');
        return $result;
    }

    //Un-Trash Ticket
    public function unTrashTicket($id) {
        $result = $this->post('/tickets/' . $id . '/trash');
        return $result;
    }

    //Delete the given ticket
    public function deleteTicket($id) {
        $result = $this->delete('/tickets/' . $id);
        return $result;
    }

    //Mark a Ticket as Spam
    public function markTicketAsSpam($id) {
        $result = $this->post('/tickets/' . $id . '/spam');
        return $result;
    }

    //Un-Spamming Tickets
    public function unSpammingTicket($id) {
        $result = $this->delete('/tickets/' . $id . '/spam');
        return $result;
    }

    //Fetching Replies
    public function getRepliesonTicket($id) {
        $result = $this->get('/tickets/' . $id . '/replies');
        return $result;
    }

    //Show Specific Reply
    public function showSpecificReplyOnTicket($ticket_id, $reply_id) {
        $result = $this->get('/tickets/' . $ticket_id . '/replies/' . $reply_id);
        return $result;
    }

    //Fetching Comments
    public function getCommentsOnTicket($ticket_id) {
        $result = $this->get('/tickets/' . $ticket_id . '/comments');
        return $result;
    }

    //Adding Labels to Ticket
    public function addLabelstoTicket($data) {
        $ticket_id = $data->getTicketId();
        $label_name = $data->getLabelName();
        $result = $this->post('/tickets/' . $ticket_id . '/labels/' . $label_name);
        $response = new \SupportBee\Model\Label();
        $response->setLabelId($result->label->id);
        $response->setTicketId($result->label->ticket);
        $response->setLabelName($result->label->label);
        return $response;
    }

    //Removing Labels from Ticket
    public function removeLabelFromTicket($data) {
        $ticket_id = $data->getTicketId();
        $label_name = $data->getLabelName();
        $result = $this->delete('/tickets/' . $ticket_id . '/labels/' . $label_name);
        return $result;
    }

    //Search Tickets
    public function searchTicket($query = NULL, $per_page = 15) {
        $parameters = array('query' => $query, 'per_page' => $per_page);
        $result = $this->get('/tickets/search', $parameters);

        $data = new Ticket();
        $data->setTotal($result->total);
        $data->setCurrentPage($result->current_page);
        $data->setPerPage($result->per_page);
        $data->setTotalPages($result->total_pages);
        $data->setTickets($result->tickets);
        return $data;
    }

    //Upload Attachment
    public function uploadFile($filename) {

        $file_content = file_get_contents('/var/www/' . $filename);
        $headers = array(
            'Content-Type' => 'multipart/form-data'
        );
        $parameters = array(
            'files[]' => $file_content
        );
        $result = $this->postRaw('/attachments', $parameters, $headers);
        return $result;
    }

}
