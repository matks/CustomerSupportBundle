<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit\Framework\TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

class MessageTest extends TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $userMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $message = new Entity\Message('Message title', $userMock, 'Message content');

        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface', $message);
    }

    public function testGetTitle()
    {
        $userMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $message = new Entity\Message('Message title', $userMock, 'Message content');

        $this->assertEquals('Message title', $message->getTitle());
    }
}
