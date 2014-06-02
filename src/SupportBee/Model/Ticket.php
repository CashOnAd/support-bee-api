<?php

namespace SupportBee\Model;

/**
 * Description of Ticket
 *
 * @author deepak
 */
class Ticket {

    /**
     *
     * @var string
     */
    private $subject;

    /**
     *
     * @var string
     */
    private $requesterEmail;

    /**
     *
     * @var string
     */
    private $requesterName;

    /**
     *
     * @var string
     */
    private $cc1;

    /**
     *
     * @var string
     */
    private $cc2;

    /**
     *
     * @var string
     */
    private $textMessage;

    /**
     *
     * @var string
     */
    private $htmlMessage;

    /**
     *
     * @var string e.g. 11,25,37
     */
    private $attachments;

    /**
     *
     * @var DateTime
     */
    private $receivedDate;

    /**
     *
     * @var DateTime
     */
    private $lastActivityDate;

    public function getSubject() {
        return $this->subject;
    }

    public function getRequesterEmail() {
        return $this->requesterEmail;
    }

    public function getRequesterName() {
        return $this->requesterName;
    }

    public function getCc1() {
        return $this->cc1;
    }

    public function getCc2() {
        return $this->cc2;
    }

    public function getTextMessage() {
        return $this->textMessage;
    }

    public function getHtmlMessage() {
        return $this->htmlMessage;
    }

    public function getAttachments() {
        return $this->attachments;
    }

    public function getReceivedDate() {
        return $this->receivedDate;
    }

    public function getLastActivityDate() {
        return $this->lastActivityDate;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setRequesterEmail($requesterEmail) {
        $this->requesterEmail = $requesterEmail;
    }

    public function setRequesterName($requesterName) {
        $this->requesterName = $requesterName;
    }

    public function setCc1($cc1) {
        $this->cc1 = $cc1;
    }

    public function setCc2($cc2) {
        $this->cc2 = $cc2;
    }

    public function setTextMessage($textMessage) {
        $this->textMessage = $textMessage;
    }

    public function setHtmlMessage($htmlMessage) {
        $this->htmlMessage = $htmlMessage;
    }

    public function setAttachments($attachments) {
        $this->attachments = $attachments;
    }

    public function setReceivedDate($receivedDate) {
        $this->receivedDate = $receivedDate;
    }

    public function setLastActivityDate($lastActivityDate) {
        $this->lastActivityDate = $lastActivityDate;
    }

}
