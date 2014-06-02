<?php

require 'vendor/autoload.php';

use \SupportBee\SupportBeeClient;

$data = new SupportBeeClient('fireflies', 'rymnBM29yFaQCMdhfNpi');

$cc = array('Test1<test1@example.com>', 'Test2<test1@example.com>');
$text = 'Creating a ticket text';
$html = 'Creating a ticket html';
$attachments = array();


//$response = $data->submitTicket(
//        'Subject Without attachement', 'Deepak Pandey', 'pandey.dip@gmail.com', $cc, $text, $html, $attachments);
//$response = $data->getAllTickets();

$response = $data->getLabels();

$result = $response->getBody('true');

$final = json_decode($result);
var_dump($final);
//echo $final->total;
exit;
