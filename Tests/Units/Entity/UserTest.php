<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testConstruct()
    {
        $user = new Entity\User('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface', $user);
    }

    public function testToString()
    {
        $user = new Entity\User('Mathieu', 'Ferment', 'mathieu@mail.com');

        $string = (string) $user;

        $this->assertEquals('mathieu@mail.com', $string);
    }

    public function testGetName()
    {
        $user = new Entity\User('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->assertEquals('Mathieu Ferment', $user->getName());
    }

    public function testIsACustomerShouldNotBeUsed()
    {
        $user = new Entity\User('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('This function should never be called on a user');
        $user->isACustomer();
    }
}