Feature: Category management
    As a company customer support agent, I should be able to manage ticket categories : create, disactivate and
    reactivate categories


  Background:
        Given I have the following active categories:
            | title           |
            | Payment issues  |
            | Delivery issues |
            | Website issues  |

    Scenario: Create new category
         When I create a new category with the title "Test category"
          The category "Test category" should be active

    Scenario: Manage categories
         When I disactivate the category "Payment issues"
          And I disactivate the category "Website issues"
         Then the category "Payment issues" should be "disactivated"
         When I reactivate the category "Website issues"
         Then category "Website issues" should be "activated"