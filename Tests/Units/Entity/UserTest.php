<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit_Framework_TestCase;

/**
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class UserTest extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $user = new Entity\User('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->assertInstanceOf('\Matks\Bundle\CustomerSupportBundle\Model\UserInterface', $user);
    }

    public function testGetName()
    {
        $user = new Entity\User('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->assertEquals('Mathieu Ferment', $user->getName());
    }

}
