<?php

namespace Matks\Bundle\CustomerSupportBundle\Reference;

/**
 * Reference Generator Interface
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
interface ReferenceGeneratorInterface
{
    /**
     * Generate unique reference
     *
     * @param  array $options
     *
     * @return string
     */
    public function generate(array $options);
}
