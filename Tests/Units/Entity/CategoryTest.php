<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

/**
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
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

    public function testDeactivate()
    {
        $category = new Entity\Category('Payment issues');

        $category->deactivate();

        $this->assertFalse($category->isActive());

        $this->setExpectedException(
            'LogicException', 'Cannot deactivate category not active'
        );
        $category->deactivate();
    }

    public function testActivate()
    {
        $category = new Entity\Category('Payment issues');

        $category->deactivate();
        $category->activate();

        $this->assertTrue($category->isActive());

        $this->setExpectedException(
            'LogicException', 'Cannot activate category already active'
        );
        $category->activate();
    }

}
