<?php

namespace Matks\Bundle\CustomerSupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company agent entity
 *
 * @ORM\Entity()
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class CompanyAgent extends User
{
    /**
     * @return bool
     */
    public function isACustomer()
    {
        return false;
    }
}
