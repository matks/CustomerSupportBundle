<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * Ticket interface
 */
interface UserInterface
{

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Whether user is a customer or a company agent
     *
     * @return boolean
     */
    public function isACustomer();
}
