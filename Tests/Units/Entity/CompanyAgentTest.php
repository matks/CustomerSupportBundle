<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Entity;

use Matks\Bundle\CustomerSupportBundle\Entity;
use PHPUnit\Framework\TestCase;

class CompanyAgentTest extends TestCase
{
    public function testIsACustomer()
    {
        $user = new Entity\CompanyAgent('Mathieu', 'Ferment', 'mathieu@mail.com');

        $this->assertFalse($user->isACustomer());
    }
}