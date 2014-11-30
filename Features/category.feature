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
    Then the category "Test category" should be "active"

  Scenario: Manage categories
    When I deactivate the category "Payment issues"
    And I deactivate the category "Website issues"
    Then the category "Payment issues" should be "inactive"
    When I reactivate the category "Website issues"
    Then the category "Website issues" should be "active"