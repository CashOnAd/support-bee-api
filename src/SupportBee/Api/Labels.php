<?php

namespace SupportBee\Api;

/**
 * Description of Labels
 *
 * @author deepak
 */
class Labels extends AbstractApi {

    //Fetching Labels
    public function fetchLabels() {
        $result = $this->get('/labels');
        return $result;
    }

}
