<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase {
    
    public function testSubscription() {
        require 'classes/Subscription.php';
        $now = new DateTime('now');
        $new_subscription = new Subscription($now, $now, 1,1,1,true);
        $this->assertEquals($now->format('Y-m-d H:i:s'), $new_subscription->start_date);
        $this->assertEquals($now->format('Y-m-d H:i:s'), $new_subscription->end_date);
        $this->assertEquals(1, $new_subscription->Id);
        $this->assertEquals(1, $new_subscription->bundle_id);
        $this->assertEquals(1, $new_subscription->user_id);
        $this->assertEquals(true, $new_subscription->active);
        unset($new_subscription);
    }
}