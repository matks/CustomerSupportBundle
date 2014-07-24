<?php

namespace Matks\Bundle\CustomerSupportBundle\Model;

/**
 * Ticket interface
 */
interface TicketInterface
{
    const STATUS_NEW = 'new';
    const STATUS_ANSWERED = 'answered';
    const STATUS_REOPENED = 'reopened';

    /**
     * Get messages
     *
     * @return MessageInterface[]
     */
    public function getMessages();

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
     * @return boolean
     */
    public function isNew();

    /**
     * @return boolean
     */
    public function isAnswered();

    /**
     * @return boolean
     */
    public function isReopened();
}
