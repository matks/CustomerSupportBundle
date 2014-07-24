<?php

namespace Matks\Bundle\CustomerSupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

use Matks\Bundle\CustomerSupportBundle\Model\TicketInterface;
use Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface;

use Doctrine\Common\Collections\ArrayCollection;
use LogicException;

/**
 * Category entity
 *
 * @ORM\Entity(repositoryClass="Matks\Bundle\CustomerSupportBundle\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class Category implements CategoryInterface
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
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var TicketInterface[]
     *
     * There are no addTicket or removeTicket functions as this is done by
     * the owning side, on Ticket entity
     *
     * @ORM\OneToMany(
     *     targetEntity="Matks\Bundle\CustomerSupportBundle\Model\TicketInterface",
     *     mappedBy="tickets",
     *     cascade={"persist", "remove", "merge"}
     * )
     * @Assert\Valid()
     */
    private $tickets;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     */
    private $enabled;

    /**
     * Constructor
     *
     * @param string $title
     */
    public function __construct($title)
    {
        $this->title = $title;
        $this->tickets = new ArrayCollection();
        $this->enabled = true;
    }

    /**
     * Get tickets associated
     *
     * @return TicketInterface[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function desactivate()
    {
        if (!$this->isActive()) {
            throw new LogicException("Cannot desactivate category not active");
        }

        if (!$this->getTickets()->isEmpty()) {
            throw new LogicException("Cannot desactivate category with tickets associated");
        }

        $this->enabled = false;
    }

    public function activate()
    {
        if ($this->isActive()) {
            throw new LogicException("Cannot activate category already active");
        }

        $this->enabled = true;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return true === $this->enabled;
    }
}
