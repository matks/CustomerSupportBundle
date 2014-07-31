<?php

namespace Matks\Bundle\CustomerSupportBundle\Manager;

use Matks\Bundle\CustomerSupportBundle\Model\CategoryInterface;

/**
 * Category Manager interface
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
interface CategoryManagerInterface
{

    /**
     * Create a new category
     * @param  string            $title
     * @return CategoryInterface
     */
    public function create($title);

    /**
     * Deactivate a category
     *
     * @param CategoryInterface $category
     */
    public function deactivate(CategoryInterface $category);

    /**
     * Reactivate a category
     *
     * @param CategoryInterface $category
     */
    public function activate(CategoryInterface $category);
}
