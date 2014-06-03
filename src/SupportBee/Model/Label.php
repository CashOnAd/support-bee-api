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
     * @var string
     */
    private $labelName;

    /**
     *
     * @var string
     */
    private $labelColor;

    public function getLabelName() {
        return $this->labelName;
    }

    public function getLabelColor() {
        return $this->labelColor;
    }

    public function setLabelName($labelName) {
        $this->labelName = $labelName;
    }

    public function setLabelColor($labelColor) {
        $this->labelColor = $labelColor;
    }

}
