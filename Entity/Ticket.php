<?php

namespace Matks\Bundle\CustomerSupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Matks\Bundle\CustomerSupportBundle\Model\TicketInterface;
use Matks\Bundle\CustomerSupportBundle\Model\MessageInterface;
use Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface;

use Doctrine\Common\Collections\ArrayCollection;
use LogicException;

/**
 * Ticket entity
 *
 * @ORM\Entity(repositoryClass="Matks\Bundle\CustomerSupportBundle\Repository\TicketRepository")
 * @ORM\Table(name="tickets")
 * @UniqueEntity(fields="reference", message="this reference already exists")
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class Ticket implements TicketInterface
{
    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var TicketInterface
     *
     * @ORM\ManyToOne(
     *      targetEntity="Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface",
     *      inversedBy="tickets"
     * )
     * @Assert\Valid()
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * Ticket unique reference
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $reference;

    /**
     * @var MessageInterface[]
     *
     * @ORM\OneToMany(
     *     targetEntity="Matks\Bundle\CustomerSupportBundle\Model\MessageInterface",
     *     mappedBy="messages",
     *     cascade={"persist", "remove", "merge"}
     * )
     * @Assert\Valid()
     */
    private $messages;

    /**
     * Constructor
     */
    public function __construct($reference, CategoryInterface $category, MessageInterface $message)
    {
        if (!$message->getAuthor()->isACustomer()) {
            throw new LogicException("Only customers can open a ticket");
        }

        $this->reference = $reference;
        $this->status = TicketInterface::STATUS_NEW;
        $this->category = $category;
        $this->messages = new ArrayCollection();
        $this->messages->add($message);
    }

    /**
     * Answer to customer ticket
     *
     * @param MessageInterface
     */
    public function answer(MessageInterface $message)
    {
        if ($this->isClosed()) {
            throw new LogicException("Cannot answer a closed ticket");
        }

        if ($message->getAuthor()->isACustomer()) {
            throw new LogicException("Only company users can answer a ticket");
        }

        $this->messages->add($message);

        $this->status = TicketInterface::STATUS_ANSWERED;
    }

    /**
     * Add new customer message to a ticket
     *
     * @param MessageInterface
     */
    public function reopen(MessageInterface $message)
    {
        if ($this->isClosed()) {
            throw new LogicException("Cannot reopen a closed ticket");
        }

        if (!$message->getAuthor()->isACustomer()) {
            throw new LogicException("Only customers can reopen a ticket");
        }

        $this->messages->add($message);

        $this->status = TicketInterface::STATUS_REOPENED;
    }

    /**
     * Close a ticket in order to prevent future answers
     */
    public function close()
    {
        $this->status = TicketInterface::STATUS_CLOSED;
    }

    /**
     * Change category
     *
     * @param CategoryInterface $category
     */
    public function changeCategory(CategoryInterface $category)
    {
        if (!$category->isActive()) {
            throw new LogicException("Cannot set new ticket category for an inactive category");
        }

        $this->category = $category;
    }

    /**
     * Get unique reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Get related category
     *
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get messages
     *
     * @return MessageInterface[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Get first message
     *
     * @return MessageInterface
     */
    public function getFirstMessage()
    {
        return $this->messages->first();
    }

    /**
     * Get last message
     *
     * @return MessageInterface
     */
    public function getLastMessage()
    {
        return $this->messages->last();
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return boolean
     */
    public function isNew()
    {
        return TicketInterface::STATUS_NEW === $this->status;
    }

    /**
     * @return boolean
     */
    public function isAnswered()
    {
        return TicketInterface::STATUS_ANSWERED === $this->status;
    }

    /**
     * @return boolean
     */
    public function isReopened()
    {
        return TicketInterface::STATUS_REOPENED === $this->status;
    }

    /**
     * @return boolean
     */
    public function isClosed()
    {
        return TicketInterface::STATUS_CLOSED === $this->status;
    }
}
