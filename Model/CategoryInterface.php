<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * Category interface
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
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
     * Deactivate category
     */
    public function deactivate();

    /**
     * Activate category
     */
    public function activate();

    /**
     * @return boolean
     */
    public function isActive();
}
