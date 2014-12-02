<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * Ticket interface
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
interface TicketInterface
{
    const STATUS_NEW      = 'new';
    const STATUS_ANSWERED = 'answered';
    const STATUS_REOPENED = 'reopened';
    const STATUS_CLOSED   = 'closed';

    /**
     * Get messages
     *
     * @return MessageInterface[]
     */
    public function getMessages();

    /**
     * Get unique reference
     *
     * @return string
     */
    public function getReference();

    /**
     * Get related category
     *
     * @return CategoryInterface
     */
    public function getCategory();

    /**
     * Answer to customer ticket, adding a company response
     *
     * @param MessageInterface $message
     */
    public function answer(MessageInterface $message);

    /**
     * Reopen a ticket with a customer message
     *
     * @param MessageInterface $message
     */
    public function reopen(MessageInterface $message);

    /**
     * Close a ticket in order to prevent future answers
     */
    public function close();

    /**
     * Change ticket category
     *
     * @param CategoryInterface $category
     */
    public function changeCategory(CategoryInterface $category);

    /**
     * Get first message
     *
     * @return MessageInterface
     */
    public function getFirstMessage();

    /**
     * Get last message
     *
     * @return MessageInterface
     */
    public function getLastMessage();

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus();

    /**
     * @return bool
     */
    public function isNew();

    /**
     * @return bool
     */
    public function isAnswered();

    /**
     * @return bool
     */
    public function isReopened();

    /**
     * @return bool
     */
    public function isClosed();
}
