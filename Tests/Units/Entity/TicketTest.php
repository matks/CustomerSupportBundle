<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use Matks\Bundle\CustomerSupportBundle\Model\TicketInterface;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

/**
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class TicketTest extends PHPUnit_Framework_TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $messageMock  = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');
        $userMock     = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(true);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock);

        $this->assertEquals(TicketInterface::STATUS_NEW, $ticket->getStatus());
        $this->assertEquals('ref', $ticket->getReference());
        $this->assertTrue($ticket->isNew());
        $this->assertSame($ticket->getFirstMessage(), $messageMock);
        $this->assertSame($ticket->getLastMessage(), $messageMock);
        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\TicketInterface', $ticket);
    }

    public function testConstructWrongCase()
    {
        $messageMock  = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');
        $userMock     = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(false);

        $this->setExpectedException(
            'LogicException', 'Only customers can open a ticket'
        );
        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock);
    }

    public function testAnswer()
    {
        $messageMock1 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $messageMock2 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');

        $userMock1    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $userMock2    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock1->method('getAuthor')
            ->willReturn($userMock1);
        $userMock1->method('isACustomer')
            ->willReturn(true);
        $messageMock2->method('getAuthor')
            ->willReturn($userMock2);
        $userMock2->method('isACustomer')
            ->willReturn(false);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock1);

        $ticket->answer($messageMock2);

        $this->assertEquals(TicketInterface::STATUS_ANSWERED, $ticket->getStatus());
        $this->assertTrue($ticket->isAnswered());
        $this->assertSame($ticket->getFirstMessage(), $messageMock1);
        $this->assertSame($ticket->getLastMessage(), $messageMock2);
    }

    public function testAnswerWrongCase()
    {
        $messageMock1 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $messageMock2 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');

        $userMock1    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $userMock2    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock1->method('getAuthor')
            ->willReturn($userMock1);
        $userMock1->method('isACustomer')
            ->willReturn(true);
        $messageMock2->method('getAuthor')
            ->willReturn($userMock2);
        $userMock2->method('isACustomer')
            ->willReturn(true);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock1);

        $this->setExpectedException(
            'LogicException', 'Only company users can answer a ticket'
        );

        $ticket->answer($messageMock2);
    }

    public function testReopen()
    {
        $messageMock1 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $messageMock2 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $messageMock3 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');

        $userMock1    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $userMock2    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock1->method('getAuthor')
            ->willReturn($userMock1);
        $userMock1->method('isACustomer')
            ->willReturn(true);
        $messageMock2->method('getAuthor')
            ->willReturn($userMock2);
        $userMock2->method('isACustomer')
            ->willReturn(false);
        $messageMock3->method('getAuthor')
            ->willReturn($userMock1);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock1);

        $ticket->answer($messageMock2);
        $ticket->reopen($messageMock3);

        $this->assertEquals(TicketInterface::STATUS_REOPENED, $ticket->getStatus());
        $this->assertTrue($ticket->isReopened());
        $this->assertSame($ticket->getFirstMessage(), $messageMock1);
        $this->assertSame($ticket->getLastMessage(), $messageMock3);
    }

    public function testReopenWrongCase()
    {
        $messageMock1 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $messageMock2 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $messageMock3 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');

        $userMock1    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $userMock2    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock1->method('getAuthor')
            ->willReturn($userMock1);
        $userMock1->method('isACustomer')
            ->willReturn(true);
        $messageMock2->method('getAuthor')
            ->willReturn($userMock2);
        $userMock2->method('isACustomer')
            ->willReturn(false);
        $messageMock3->method('getAuthor')
            ->willReturn($userMock2);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock1);
        $ticket->answer($messageMock2);

        $this->setExpectedException(
            'LogicException', 'Only customers can reopen a ticket'
        );

        $ticket->reopen($messageMock3);
    }

    public function testChangeCategory()
    {
        $messageMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $userMock    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $categoryMock1 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');
        $categoryMock2 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(true);
        $categoryMock2->method('isActive')
            ->willReturn(true);

        $ticket = new Entity\Ticket('ref', $categoryMock1, $messageMock);

        $this->assertSame($ticket->getCategory(), $categoryMock1);

        $ticket->changeCategory($categoryMock2);

        $this->assertSame($ticket->getCategory(), $categoryMock2);
    }

    public function testChangeCategoryWrongCase()
    {
        $messageMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $userMock    = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $categoryMock1 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');
        $categoryMock2 = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(true);
        $categoryMock2->method('isActive')
            ->willReturn(false);

        $ticket = new Entity\Ticket('ref', $categoryMock1, $messageMock);

        $this->setExpectedException(
            'LogicException', 'Cannot set new ticket category for an inactive category'
        );

        $ticket->changeCategory($categoryMock2);
    }

    public function testClose()
    {
        $messageMock  = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $userMock     = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(true);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock);
        $ticket->close();

        $this->assertEquals(TicketInterface::STATUS_CLOSED, $ticket->getStatus());
        $this->assertTrue($ticket->isClosed());
    }

    public function testAnswerAfterClose()
    {
        $messageMock  = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $userMock     = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(true);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock);
        $ticket->close();

        $this->setExpectedException(
            'LogicException', 'Cannot answer a closed ticket'
        );

        $ticket->answer($messageMock);
    }

    public function testReopenAfterClose()
    {
        $messageMock  = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $userMock     = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');
        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $messageMock->method('getAuthor')
            ->willReturn($userMock);
        $userMock->method('isACustomer')
            ->willReturn(true);

        $ticket = new Entity\Ticket('ref', $categoryMock, $messageMock);
        $ticket->close();

        $this->setExpectedException(
            'LogicException', 'Cannot reopen a closed ticket'
        );

        $ticket->reopen($messageMock);
    }

}
