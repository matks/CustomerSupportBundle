<?php

namespace Matks\Bundle\CustomerSupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

use Matks\Bundle\CustomerSupportBundle\Model\MessageInterface;
use Matks\Bundle\CustomerSupportBundle\Model\UserInterface;

/**
 * Message entity
 *
 * @ORM\Entity(repositoryClass="Matks\Bundle\CustomerSupportBundle\Repository\MessageRepository")
 * @ORM\Table(name="messages")
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class Message implements MessageInterface
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
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var TicketInterface
     *
     * @ORM\ManyToOne(
     *      targetEntity="Matks\Bundle\CustomerSupportBundle\Model\TicketInterface",
     *      inversedBy="messages"
     * )
     * @Assert\Valid()
     */
    private $ticket;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(
     *      targetEntity="Matks\Bundle\CustomerSupportBundle\Model\UserInterface",
     *      inversedBy="messages"
     * )
     * @Assert\Valid()
     */
    private $user;

    /**
     * Constructor
     *
     * @param string        $title
     * @param UserInterface $user
     * @param string        $content
     */
    public function __construct($title, UserInterface $user, $content)
    {
        $this->title   = $title;
        $this->user    = $user;
        $this->content = $content;
    }

    /**
     * Get author
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->user;
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

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

}
