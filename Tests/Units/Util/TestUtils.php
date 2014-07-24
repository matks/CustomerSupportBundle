<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

/**
 * Util shortcuts for tests
 */
trait TestUtils
{

    private function getBasicMock($className)
    {
        $mock = $this->getMockBuilder($className)
                     ->disableOriginalConstructor()
                     ->getMock();

        return $mock;
    }

}
