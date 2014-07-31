<?php

namespace Matks\Bundle\CustomerSupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer entity
 *
 * @ORM\Entity()
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class Customer extends User
{
    public function isACustomer()
    {
        return true;
    }
}
