<?php
class Subscription {
    // Properties
    public $Id;
    public $start_date;
    public $end_date;
    public $user_id;
    public $bundle_id;
    public $active;

    // Constructor
    public function __construct(Datetime $start_date, Datetime $end_date,int $user_id, int $bundle_id, $Id = null, $active = null, $duration = null) {
        // create a new product on startup
        $this->start_date = $start_date->format('Y-m-d H:i:s');
        if($duration) {
            $this->end_date = $end_date->modify($duration)->format('Y-m-d H:i:s');
        } else {
            $this->end_date = $end_date->format('Y-m-d H:i:s');
        }
        $this->user_id = $user_id;
        $this->bundle_id = $bundle_id;
        $this->active = $active;
        $this->Id = $Id;
    }

    public function __toString() {
        $active_string = '';
        if($this->active) {
            $active_string = 'active';
        } else {
            $active_string = 'not active';
        }

        return "<p>Subscription for user with Id: $this->user_id</p>
                <p>to bundle with Id: $this->bundle_id</p>
                <p>started on: $this->start_date</p>
                <p>ends on: $this->end_date</p>
                <p>subscrition is $active_string</p>";
    }

    public function addSubscriptionTime($duration) {
        $new_date = new DateTime($this->end_date);
        $this->end_date = $new_date->modify($duration)->format('Y-m-d H:i:s');
    }
}