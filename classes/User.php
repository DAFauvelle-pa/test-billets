<?php
class User {
    // Properties
    public $Id;
    public $user_name;
    public $user_email;

    // Constructor
    public function __construct(string $user_name, string $user_email, int $Id) {
        // create a new product on startup
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->Id = $Id;
    }

    public function __toString() {
        return "User: " . $this->user_name . " Email: " . $this->user_email;
    }
}