<?php

namespace SupportBee\Model;

/**
 * Description of Label
 *
 * @author deepak
 */
class Label {

    /**
     *
     * @var int
     */
    private $labelId;

    /**
     *
     * @var string
     */
    private $labelName;

    /**
     *
     * @var string
     */
    private $labelColor;

    /**
     *
     * @var int
     */
    private $ticketId;

    public function getLabelId() {
        return $this->labelId;
    }

    public function getLabelName() {
        return $this->labelName;
    }

    public function getLabelColor() {
        return $this->labelColor;
    }

    public function getTicketId() {
        return $this->ticketId;
    }

    public function setLabelId($labelId) {
        $this->labelId = $labelId;
    }

    public function setLabelName($labelName) {
        $this->labelName = $labelName;
    }

    public function setLabelColor($labelColor) {
        $this->labelColor = $labelColor;
    }

    public function setTicketId($ticketId) {
        $this->ticketId = $ticketId;
    }

}
