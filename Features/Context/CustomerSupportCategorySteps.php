<?php

namespace Matks\Bundle\CustomerSupportBundle\Features\Context;

use Matks\Bundle\CustomerSupportBundle\Entity\Category;

use Behat\Gherkin\Node\TableNode;
use LogicException;
use Exception;

/**
 * CustomerSupportBundle behat steps
 */
trait CustomerSupportCategorySteps
{
    /**
     * Get the category repository
     *
     * @return Doctrine\Common\Persistence\ObjectRepository
     */
    public function getCategoryRepository()
    {
        return $this
            ->kernel
            ->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('CustomerSupportBundle:Category')
        ;
    }

    /**
     * Get the category manager
     *
     * @return CategoryManagerInterface
     */
    public function getCategoryManager()
    {
        return $this->kernel->getContainer()->get('matks.support.category.manager');
    }

    /**
     * Find a category with the given title
     *
     * @Transform /^category "([^"]*)"$/
     *
     * @param  string         $reference
     * @return Category
     * @throws LogicException
     */
    public function findCategory($title)
    {
        if (null === $title) {
            throw new LogicException('Unable to find a category without a title');
        }

        $category = $this->getCategoryRepository()->findOneByTitle($title);

        return $category;
    }

    /**
     * @Given /^I have the following active categories:$/
     */
    public function setupCategories(TableNode $table)
    {
        foreach ($table->getHash() as $data) {
            $category = new Category($data['title']);
            $this->getEntityManager()->persist($category);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @When /^I create a new category with the title "([^"]*)"$/
     */
    public function createCategory($title)
    {
        $category = new Category($title);
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    /**
     * @When /^I (deactivate|activate|reactivate) the (category "[^"]*")$/
     */
    public function categoryAction($action, Category $category)
    {
        switch ($action) {
            case 'activate':
                $this->getCategoryManager()->activate($category);
                break;

            case 'reactivate':
                $this->getCategoryManager()->activate($category);
                break;


            case 'deactivate':
                $this->getCategoryManager()->deactivate($category);
                break;

            default:
                throw new Exception("Unknown category action ".$action);
                break;
        }
    }

    /**
     * @Then /^the (category "[^"]*") should be "([^"]*)"$/
     */
    public function assertCategoryState(Category $category, $state)
    {
        switch ($state) {
            case 'active':
                if (!$category->isActive()) {
                    throw new Exception("Category ".$category->getTitle()." is not active");
                }
                break;

            case 'inactive':
                if ($category->isActive()) {
                    throw new Exception("Category ".$category->getTitle()." is active");
                }
                break;

            default:
                throw new Exception("Unknown category state ".$state);
                break;
        }
    }

    /**
     * @Given /^the (category "[^"]*") should have no tickets$/
     */
    public function assertCategoryEmpty(Category $category)
    {
        if (!$category->getTickets()->isEmpty()) {
            throw new Exception("Category ".$category->getTitle()." should be empty but is not");
        }
    }

}
