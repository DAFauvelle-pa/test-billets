<?php
class Bundle {
    // Properties
    public $Id;
    public $title;

    // Constructor
    public function __construct(string $title, $Id) {
        // create a new product on startup
        $this->title = $title;
        $this->Id = $Id;
    }

    public function __toString() {
        return "Product bundle: " . $this->title;
    }
}