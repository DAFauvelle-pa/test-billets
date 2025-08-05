<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class BundleTest extends TestCase {
    public function testBundle() {
        require 'classes/Bundle.php';
        $new_bundle = new Bundle('test-title', 1);
        $this->assertEquals('test-title', $new_bundle->title);
        $this->assertEquals(1, $new_bundle->Id);
        unset($new_bundle);
    }
}