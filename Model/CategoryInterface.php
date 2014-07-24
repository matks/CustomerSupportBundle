<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * Ticket interface
 */
interface CategoryInterface
{

    /**
     * Get tickets associated
     *
     * @return TicketInterface[]
     */
    public function getTickets();

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Desactivate category
     */
    public function desactivate();

    /**
     * Activate category
     */
    public function activate();

    /**
     * @return boolean
     */
    public function isActive();
}
