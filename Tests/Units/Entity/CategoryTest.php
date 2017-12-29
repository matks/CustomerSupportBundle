<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit\Framework\TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;
use LogicException;

class CategoryTest extends TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $category = new Entity\Category('Payments issues');

        $this->assertTrue($category->isActive());
        $this->assertTrue($category->getTickets()->isEmpty());
        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface', $category);
    }

    public function testDeactivate()
    {
        $category = new Entity\Category('Payment issues');

        $category->deactivate();

        $this->assertFalse($category->isActive());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cannot deactivate category not active');
        $category->deactivate();
    }

    public function testActivate()
    {
        $category = new Entity\Category('Payment issues');

        $category->deactivate();
        $category->activate();

        $this->assertTrue($category->isActive());

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cannot activate category already active');
        $category->activate();
    }

}
