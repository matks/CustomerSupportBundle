<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

/**
 * Util shortcuts for tests
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
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
