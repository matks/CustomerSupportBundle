<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * User interface
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
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
