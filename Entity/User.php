<?php

namespace Matks\Bundle\CustomerSupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Matks\Bundle\CustomerSupportBundle\Model\UserInterface;

/**
 * User entity
 *
 * @ORM\Entity(repositoryClass="Matks\Bundle\CustomerSupportBundle\Repository\UserRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\Table(name="users", indexes={@ORM\Index(name="user_email_idx", columns={"email"})})
 * @UniqueEntity(fields="email", message="this email already exists")
 * @ORM\HasLifecycleCallbacks
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class User implements UserInterface
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
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="first_name")
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="last_name")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var Name
     */
    private $name;

    /**
     * Constructor
     */
    public function __construct($firstName, $lastName, $email)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
    }

    public function __toString()
    {
        return $this->email;
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function isACustomer()
    {
        throw new Exception("This function should never be called on a user");
    }
}
