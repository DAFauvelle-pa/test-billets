<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    
    public function testUser() {
        $new_user = new User('test-name', 'test-email', 1);
        $this->assertEquals('test-name', $new_user->user_name);
        $this->assertEquals('test-email', $new_user->user_email);
        $this->assertEquals(1, $new_user->Id);
        unset($new_subscription);
    }
}