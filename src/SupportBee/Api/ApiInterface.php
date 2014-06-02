<?php

namespace SupportBee\Api;

use SupportBee\Client;

/**
 * Description of ApiInterface
 *
 * @author deepak
 */
interface ApiInterface {

    public function __construct(Client $client);

    public function getPerPage();

    public function setPerPage($perPage);
}
