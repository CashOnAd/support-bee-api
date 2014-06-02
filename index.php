<?php

require 'vendor/autoload.php';

use SupportBee\Client;
use SupportBee\Model\Ticket;

$client = new Client();

//$ticket = $client->api('tickets')->getTickets((int) 20);
//var_dump($ticket);
//echo $ticket->getCc1();
//$data = new Ticket();
//$data->setSubject('This is test');
//$data->setRequesterName('CashonAd Pte Ltd');
//$data->setRequesterEmail('cashonad@cashonad.coom');
//$data->setCc1('Deepak<pandey.dip@gmail.com>');
//$data->setTextMessage('We are here to test functionality text');
//$data->setHtmlMessage('<h3>We are here to test functionality text html</h3>');
//$create_ticket = $client->api('tickets')->createTickets($data);
//$create_ticket = $client->api('tickets')->createTickets($data_array);
//var_dump($create_ticket);



$show_ticket = $client->api('tickets')->showTicket('2611423');
echo 'Ticket Subject => ' . $show_ticket->getSubject() . '<br/>';
echo 'Requester Name => ' . $show_ticket->getRequesterName() . '<br/>';
echo 'Requester Email => ' . $show_ticket->getRequesterEmail() . '<br/>';
echo 'Text Message => ' . $show_ticket->getTextMessage() . '<br/>';
echo 'Created At => ' . $show_ticket->getReceivedDate() . '<br/>';
echo 'Modified At => ' . $show_ticket->getLastActivityDate() . '<br/>';

