<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Manager;

use Matks\Bundle\CustomerSupportBundle\Manager;
use PHPUnit\Framework\TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

class CategoryManagerTest extends TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $doctrineMock = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');

        $manager = new Manager\CategoryManager($doctrineMock, 'foo');
    }

    public function testCreate()
    {
        $doctrineMock      = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');

        $doctrineMock->method('getManager')
            ->willReturn($entityManagerMock);

        $manager = new Manager\CategoryManager($doctrineMock, '\Matks\Bundle\CustomerSupportBundle\Entity\Category');

        $entityManagerMock->expects($this->once())
            ->method('persist');
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $category = $manager->create('Test');
    }

    public function testActivate()
    {
        $doctrineMock      = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');
        $categoryMock      = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $doctrineMock->method('getManager')
            ->willReturn($entityManagerMock);

        $manager = new Manager\CategoryManager($doctrineMock, '\Matks\Bundle\CustomerSupportBundle\Entity\Category');

        $entityManagerMock->expects($this->once())
            ->method('flush');
        $categoryMock->expects($this->once())
            ->method('activate');

        $category = $manager->activate($categoryMock);
    }

    public function testDeactivate()
    {
        $doctrineMock      = $this->getBasicMock('\Doctrine\Common\Persistence\ManagerRegistry');
        $entityManagerMock = $this->getBasicMock('\Doctrine\Common\Persistence\ObjectManager');
        $categoryMock      = $this->getBasicMock('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface');

        $doctrineMock->method('getManager')
            ->willReturn($entityManagerMock);

        $manager = new Manager\CategoryManager($doctrineMock, '\Matks\Bundle\CustomerSupportBundle\Entity\Category');

        $entityManagerMock->expects($this->once())
            ->method('flush');
        $categoryMock->expects($this->once())
            ->method('deactivate');

        $category = $manager->deactivate($categoryMock);
    }
}
