<?php

namespace Matks\Bundle\CustomerSupportBundle\Manager;

use Matks\Bundle\CustomerSupportBundle\Model\TicketInterface;
use Matks\Bundle\CustomerSupportBundle\Model\MessageInterface;
use Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface;

/**
 * Ticket Manager interface
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
interface TicketManagerInterface
{
    /**
     * Create a new ticket
     * @param  CategoryInterface $category
     * @param  MessageInterface  $message
     * @return TicketInterface
     */
    public function create(CategoryInterface $category, MessageInterface $message);

    /**
     * Answer to a ticket
     * @param TicketInterface  $ticket
     * @param MessageInterface $message
     */
    public function answer(TicketInterface $ticket, MessageInterface $message);

    /**
     * Reopen an answered ticket
     * @param TicketInterface  $ticket
     * @param MessageInterface $message
     */
    public function reopen(TicketInterface $ticket, MessageInterface $message);

    /**
     * Shift a ticket category
     * @param TicketInterface   $ticket
     * @param CategoryInterface $category
     */
    public function changeCategory(TicketInterface $ticket, CategoryInterface $category);
}
