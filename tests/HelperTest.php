<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase {

    public function testFindObjectInArrayById() {
        require 'classes/Helper.php';
        include 'classes/User.php';

        $helper = new Helper();
        $data_array = [
            new User('user 1', 'user@user.com', 1),
            new User('user 2', 'user2@user.com', 2)
        ];
        $found_object = $helper->findObjectInArrayById($data_array, 2);
        $this->assertEquals($found_object->Id, 2);
        unset($helper);
    }
    
    public function testTestInput() {
        $helper = new Helper();

        $data = 'test data\  ';

        $fixed_data = $helper->testInput($data);
        $this->assertEquals('test data', $fixed_data);

        unset($helper);
    }
}