<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

class MessageTest extends PHPUnit_Framework_TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $userMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $message = new Entity\Message('Message title', $userMock, 'Message content');

        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface', $message);
    }
}
