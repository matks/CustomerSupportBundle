<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * Ticket interface
 */
interface MessageInterface
{
    /**
     * Get author
     *
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get content
     *
     * @return string
     */
    public function getContent();
}
