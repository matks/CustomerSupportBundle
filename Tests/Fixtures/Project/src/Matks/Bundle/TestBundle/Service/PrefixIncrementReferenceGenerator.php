<?php

namespace Matks\Bundle\TestBundle\Service;

use Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Predictable reference generator for test purposes only
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class PrefixIncrementReferenceGenerator implements ReferenceGeneratorInterface
{
    private $increment;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->increment = $doctrine->getRepository('CustomerSupportBundle:Ticket')
            ->createQueryBuilder('i')
            ->select('COUNT(i)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    public function generate(array $options)
    {
        return sprintf('TICKET-%d', ++$this->increment);
    }

}
