<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Manager;

use Matks\Bundle\CustomerSupportBundle\Manager;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

class TicketManagerTest extends PHPUnit_Framework_TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $referenceGeneratorMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface');
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');

        $manager = new Manager\TicketManager($doctrineMock, $referenceGeneratorMock, 'foo');
    }

    public function testCreate()
    {
        $referenceGeneratorMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface');
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');
        $messageMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');
        $userMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface');

        $doctrineMock->method('getManager')
                     ->willReturn($entityManagerMock);
        $messageMock->method('getAuthor')
                     ->willReturn($userMock);
        $userMock->method('isACustomer')
                     ->willReturn(true);

        $manager = new Manager\TicketManager($doctrineMock, $referenceGeneratorMock, '\Matks\Bundle\CustomerSupportBundle\Entity\Ticket');

        $entityManagerMock->expects($this->once())
                         ->method('persist');
        $entityManagerMock->expects($this->once())
                         ->method('flush');
        $referenceGeneratorMock->expects($this->once())
                         ->method('generate');

        $ticket = $manager->create($categoryMock, $messageMock);
    }

    public function testAnswer()
    {
        $referenceGeneratorMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface');
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $ticketMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\TicketInterface');
        $messageMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');

        $doctrineMock->method('getManager')
                     ->willReturn($entityManagerMock);

        $manager = new Manager\TicketManager($doctrineMock, $referenceGeneratorMock, 'foo');

        $entityManagerMock->expects($this->once())
                         ->method('flush');
        $ticketMock->expects($this->once())
                         ->method('answer');

        $manager->answer($ticketMock, $messageMock);
    }

    public function testReopen()
    {
        $referenceGeneratorMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface');
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $ticketMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\TicketInterface');
        $messageMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\MessageInterface');

        $doctrineMock->method('getManager')
                     ->willReturn($entityManagerMock);

        $manager = new Manager\TicketManager($doctrineMock, $referenceGeneratorMock, 'foo');

        $entityManagerMock->expects($this->once())
                         ->method('flush');
        $ticketMock->expects($this->once())
                         ->method('reopen');

        $manager->reopen($ticketMock, $messageMock);
    }

    public function testClose()
    {
        $referenceGeneratorMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface');
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $ticketMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\TicketInterface');

        $doctrineMock->method('getManager')
                     ->willReturn($entityManagerMock);

        $manager = new Manager\TicketManager($doctrineMock, $referenceGeneratorMock, 'foo');

        $entityManagerMock->expects($this->once())
                         ->method('flush');
        $ticketMock->expects($this->once())
                         ->method('close');

        $manager->close($ticketMock);
    }

    public function testChangeCategory()
    {
        $referenceGeneratorMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface');
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $categoryMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');
        $ticketMock = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\TicketInterface');

        $doctrineMock->method('getManager')
                     ->willReturn($entityManagerMock);

        $manager = new Manager\TicketManager($doctrineMock, $referenceGeneratorMock, 'foo');

        $entityManagerMock->expects($this->once())
                         ->method('flush');
        $ticketMock->expects($this->once())
                         ->method('changeCategory');

        $manager->changeCategory($ticketMock, $categoryMock);
    }
}
