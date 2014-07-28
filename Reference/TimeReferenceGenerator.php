<?php

namespace Matks\Bundle\CustomerSupportBundle\Reference;

use DateTime;

/**
 * Time Reference Generator
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class TimeReferenceGenerator implements ReferenceGeneratorInterface
{

    /**
     * Generate unique reference based on current time
     *
     * @param  array  $options
     * @return string
     */
    public function generate(array $options)
    {
        $randomPart = rand(100, 999);

        list($usec, $sec) = explode(' ', microtime());

        $microtime = explode('.', $usec)[1];
        $datetime = (new DateTime())->format('YmdHis');

        return $datetime . $microtime . $randomPart;
    }

}
