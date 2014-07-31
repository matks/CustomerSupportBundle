<?php

namespace Matks\Bundle\CustomerSupportBundle\Repository;

use Matks\Bundle\CustomerSupportBundle\Model\TicketInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Ticket repository
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class TicketRepository extends EntityRepository
{
    public function countOpenedTickets()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.status IN (:openedStatuses)')
            ->setParameter(':openedStatuses', [TicketInterface::STATUS_NEW, TicketInterface::STATUS_REOPENED])
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
