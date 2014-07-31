Feature: Tickets lifecycle with a customer and a company agent
    As a company customer support agent, I should be able to read customers messages, dispatched in tickets,
    and answer them.


  Background:
        Given I have the following users:
            | firstname | lastname | email            | type          | 
            | Pierre    | Henry    | pierre@mail.com  | customer      |
            | Maxime    | Hollande | maxime@mail.com  | customer      |
            | Mathieu   | Ferment  | mathieu@mail.com | company agent |
         And I have the following active categories:
            | title           |
            | Payment issues  |
            | Delivery issues |
            | Website issues  |

    Scenario: Open and answer tickets
        Given I have 0 opened tickets
         When the user "Pierre" create a ticket in the category "Payment issues" with the following message:
            | title        | content                                                                                        |
            | My invoice   | Hello, I did not receive the invoice for my order of a bike on the 3rd of June. Cheers, Pierre |
          And the user "Pierre" create a ticket in the category "Delivery issues" with the following message:
            | title        | content                                                                                        |
            | My bike   | Hello, I did not receive the bike I ordered on the 3rd of June. Cheers, Pierre |
         Then I should have 2 opened tickets
        When the user "Mathieu" answers to the ticket "TICKET-1" with the following message:
            | title           | content                                                                                     |
            | Re:My invoice   | Hello Sir, You did not receive an invoice because you did not pay. Yours sincerely, Mathieu |
         And the user "Mathieu" answers to the ticket "TICKET-2" with the following message:
            | title           | content                                                                                            |
            | Re:My bike   | Hello Sir, You did not receive the bike you ordered because you did not pay. Yours sincerely, Mathieu |
        Then I should have 0 opened tickets
         And the ticket "TICKET-1" should be "answered"
         And the ticket "TICKET-2" should be "answered"
        When the user "Pierre" reopens to the ticket "TICKET-1" with the following message:
            | title              | content                                              |
            | Re:Re:My invoice   | Hello Sir, Thank you for your answer. Cheers, Pierre |
         And I close the ticket "TICKET-1"
        Then I should have 0 opened tickets
         And the ticket "TICKET-1" should be "closed"

    Scenario: Manage tickets
        Given I have 0 opened tickets
         When the user "Maxime" create a ticket in the category "Payment issues" with the following message:
            | title        | content          |
            | Test ticket  | Just some text   |
         And I shift the ticket "TICKET-1" into the category "Website issues"
         And I close the ticket "TICKET-1"
        Then the ticket "TICKET-1" should be "closed"
         And the ticket "TICKET-1" should be in the category "Website issues"
         And the category "Payment issues" should have no tickets