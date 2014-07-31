<?php

namespace Matks\Bundle\CustomerSupportBundle\Features\Context;

use Matks\Bundle\CustomerSupportBundle\Entity\Customer;
use Matks\Bundle\CustomerSupportBundle\Entity\CompanyAgent;
use Matks\Bundle\CustomerSupportBundle\Entity\Message;
use Matks\Bundle\CustomerSupportBundle\Entity\Ticket;
use Matks\Bundle\CustomerSupportBundle\Entity\Category;

use Matks\Bundle\CustomerSupportBundle\Model\UserInterface;

use Behat\Gherkin\Node\TableNode;
use LogicException;
use Exception;

/**
 * CustomerSupportBundle behat steps
 */
trait CustomerSupportTicketSteps
{
    /**
     * Get the ticket repository
     *
     * @return Doctrine\Common\Persistence\ObjectRepository
     */
    public function getTicketRepository()
    {
        return $this
            ->kernel
            ->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('CustomerSupportBundle:Ticket')
        ;
    }

    /**
     * Get the user repository
     *
     * @return Doctrine\Common\Persistence\ObjectRepository
     */
    public function getUserRepository()
    {
        return $this
            ->kernel
            ->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('CustomerSupportBundle:User')
        ;
    }

    /**
     * Get the ticket manager
     *
     * @return TicketManagerInterface
     */
    public function getTicketManager()
    {
        return $this->kernel->getContainer()->get('matks.support.ticket.manager');
    }

    /**
     * Find a user with the given firstname
     *
     * @Transform /^user "([^"]*)"$/
     *
     * @param  string         $email
     * @return UserInterface
     * @throws LogicException
     */
    public function findUser($firstname)
    {
        if (null === $firstname) {
            throw new LogicException('Unable to find a user without a firstname');
        }

        $user = $this->getUserRepository()->findOneByFirstName($firstname);

        return $user;
    }

    /**
     * Find a ticket with the given reference
     *
     * @Transform /^ticket "([^"]*)"$/
     *
     * @param  string         $reference
     * @return Ticket
     * @throws LogicException
     */
    public function findTicket($reference)
    {
        if (null === $reference) {
            throw new LogicException('Unable to find a ticket without a reference');
        }

        $ticket = $this->getTicketRepository()->findOneByReference($reference);

        return $ticket;
    }

    /**
     * @Given /^I have the following users:$/
     */
    public function setupUsers(TableNode $table)
    {
        foreach ($table->getHash() as $data) {

            switch ($data['type']) {
                case 'customer':
                    $user = new Customer($data['firstname'], $data['lastname'], $data['email']);
                    break;

                case 'company agent':
                    $user = new CompanyAgent($data['firstname'], $data['lastname'], $data['email']);
                    break;

                default:
                    throw new Exception("Unknown user type ".$data['type']);
                    break;
            }

            $this->getEntityManager()->persist($user);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @When /^the (user "[^"]*") create a ticket in the (category "[^"]*") with the following message:$/
     */
    public function createTicket(UserInterface $user, Category $category, TableNode $table)
    {
        $messageRows = $table->getHash();
        if (count($messageRows) != 1) {
            throw new LogicException('Message table supports exactly one line');
        }
        $messageData = $messageRows[0];

        $message = new Message($messageData['title'], $user, $messageData['content']);
        $this->getEntityManager()->persist($message);

        $ticket = $this->getTicketManager()->create($category, $message);
        $this->getEntityManager()->flush();
    }

    /**
     * @When /^the (user "[^"]*") answers to the (ticket "[^"]*") with the following message:$/
     */
    public function userAnswersTicket(UserInterface $user, Ticket $ticket, TableNode $table)
    {
        $messageRows = $table->getHash();
        if (count($messageRows) != 1) {
            throw new LogicException('Message table supports exactly one line');
        }
        $messageData = $messageRows[0];

        $message = new Message($messageData['title'], $user, $messageData['content']);
        $this->getEntityManager()->persist($message);

        $this->getTicketManager()->answer($ticket, $message);
        $this->getEntityManager()->flush();
    }

    /**
     * @When /^the (user "[^"]*") reopens to the (ticket "[^"]*") with the following message:$/
     */
    public function userReopensTicket(UserInterface $user, Ticket $ticket, TableNode $table)
    {
        $messageRows = $table->getHash();
        if (count($messageRows) != 1) {
            throw new LogicException('Message table supports exactly one line');
        }
        $messageData = $messageRows[0];

        $message = new Message($messageData['title'], $user, $messageData['content']);
        $this->getEntityManager()->persist($message);

        $this->getTicketManager()->reopen($ticket, $message);
        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^I close the (ticket "[^"]*")$/
     */
    public function closeTicket(Ticket $ticket)
    {
        $this->getTicketManager()->close($ticket);
        $this->getEntityManager()->flush();
    }

    /**
     * @Given /^I shift the (ticket "[^"]*") into the (category "[^"]*")$/
     */
    public function shiftTicketCategory(Ticket $ticket, Category $category)
    {
        $this->getTicketManager()->changeCategory($ticket, $category);
        $this->getEntityManager()->flush();
    }



    /**
     * @Given /^I have (\d+) opened tickets$/
     * @Then /^I should have (\d+) opened tickets$/
     */
    public function assertOpenedTicketsTotal($count)
    {
        $openedTickets = $this->getTicketRepository()->countOpenedTickets();
        if ($count !== $openedTickets) {
            throw new Exception("Opened tickets should be ".$count." but are actually ".$openedTickets);
        }
    }

    /**
     * @Given /^the (ticket "[^"]*") should be "([^"]*)"$/
     */
    public function assertTicketStatus(Ticket $ticket, $state)
    {
        if ($ticket->getStatus() !== $state) {
            throw new Exception("Ticket should be ".$state." but is ".$ticket->getStatus());
        }
    }

    /**
     * @Given /^the (ticket "[^"]*") should be in the (category "[^"]*")$/
     */
    public function assertTicketCategory(Ticket $ticket, Category $category)
    {
        if ($ticket->getCategory()->getTitle() !== $category->getTitle()) {
            throw new Exception("Ticket should be in category ".$category->getTitle()." but is in ".$ticket->getCategory()->getTitle());
        }
    }

}
