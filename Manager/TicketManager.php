<?php

namespace Matks\Bundle\CustomerSupportBundle\Manager;

use Matks\Bundle\CustomerSupportBundle\Model\TicketInterface;
use Matks\Bundle\CustomerSupportBundle\Model\MessageInterface;
use Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface;

use Matks\Bundle\CustomerSupportBundle\Reference\ReferenceGeneratorInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Ticket Manager
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class TicketManager implements TicketManagerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var ReferenceGeneratorInterface
     */
    private $referenceGenerator;

    /**
     * @var string Ticket FQDN
     */
    private $ticketClass;

    /**
     * Constructor
     *
     * @param ReferenceGeneratorInterface $referenceGenerator
     * @param ManagerRegistry             $doctrine
     * @param string                      $ticketClass
     */
    public function __construct(ReferenceGeneratorInterface $referenceGenerator, ManagerRegistry $doctrine, $ticketClass)
    {
        $this->referenceGenerator = $referenceGenerator;
        $this->doctrine = $doctrine;
        $this->ticketClass = $ticketClass;
    }

    /**
     * Create a new ticket
     *
     * @param  CategoryInterface $category
     * @param  MessageInterface  $message
     * @return TicketInterface
     */
    public function create(CategoryInterface $category, MessageInterface $message)
    {
        $reference = $this->referenceGenerator->generate([]);

        $ticket = new $this->ticketClass($reference, $category, $message);
        $this->doctrine->getManager()->persist($ticket);
        $this->doctrine->getManager()->flush();

        return $ticket;
    }

    /**
     * Answer to a ticket
     *
     * @param TicketInterface  $ticket
     * @param MessageInterface $message
     */
    public function answer(TicketInterface $ticket, MessageInterface $message)
    {
        $ticket->answer($message);
        $this->doctrine->getManager()->flush();
    }

    /**
     * Reopen an answered ticket
     *
     * @param TicketInterface  $ticket
     * @param MessageInterface $message
     */
    public function reopen(TicketInterface $ticket, MessageInterface $message)
    {
        $ticket->reopen($message);
        $this->doctrine->getManager()->flush();
    }

    /**
     * Shift a ticket category
     *
     * @param TicketInterface   $ticket
     * @param CategoryInterface $category
     */
    public function changeCategory(TicketInterface $ticket, CategoryInterface $category)
    {
        $ticket->changeCategory($category);
        $this->doctrine->getManager()->flush();
    }
}
