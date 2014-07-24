<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

class CategoryTest extends PHPUnit_Framework_TestCase
{
    use Util\TestUtils;

    public function testConstruct()
    {
        $category = new Entity\Category('Payments issues');

        $this->assertTrue($category->isActive());
        $this->assertTrue($category->getTickets()->isEmpty());
        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface', $category);
    }

    public function testDesactivate()
    {
        $category = new Entity\Category('Payment issues');

        $category->desactivate();

        $this->assertFalse($category->isActive());

        $this->setExpectedException(
          'LogicException', 'Cannot desactivate category not active'
        );
        $category->desactivate();
    }

    public function testActivate()
    {
        $category = new Entity\Category('Payment issues');

        $category->desactivate();
        $category->activate();

        $this->assertTrue($category->isActive());

        $this->setExpectedException(
          'LogicException', 'Cannot activate category already active'
        );
        $category->activate();
    }

}
