<?php

namespace Matks\Bundle\CustomerSupportBundle\Manager;

use Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Category Manager
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class CategoryManager implements CategoryManagerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var string Category FQDN
     */
    private $categoryClass;

    /**
     * Constructor
     *
     * @param ManagerRegistry $doctrine
     * @param string          $categoryClass
     */
    public function __construct(ManagerRegistry $doctrine, $categoryClass)
    {
        $this->doctrine = $doctrine;
        $this->categoryClass = $categoryClass;
    }

    /**
     * Create a new category
     * @param  string            $title
     * @return CategoryInterface
     */
    public function create($title)
    {
        $category = new $this->categoryClass($title);
        $this->doctrine->getManager()->persist($category);
        $this->doctrine->getManager()->flush();

        return $category;
    }

    /**
     * Deactivate a category
     *
     * @param CategoryInterface $category
     */
    public function deactivate(CategoryInterface $category)
    {
        $category->deactivate();
        $this->doctrine->getManager()->flush();
    }

    /**
     * Reactivate a category
     *
     * @param CategoryInterface $category
     */
    public function activate(CategoryInterface $category)
    {
        $category->activate();
        $this->doctrine->getManager()->flush();
    }
}
