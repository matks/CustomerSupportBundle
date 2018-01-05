<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testIsACustomer()
    {
        $user = new Entity\Customer('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->assertTrue($user->isACustomer());
    }
}