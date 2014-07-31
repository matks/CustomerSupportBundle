<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Reference;

use Matks\Bundle\CustomerSupportBundle\Reference;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

/**
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class TimeReferenceGeneratorTest extends PHPUnit_Framework_TestCase
{
    use Util\TestUtils;

    public function testGenerate()
    {
        date_default_timezone_set('UTC');
        $generator = new Reference\TimeReferenceGenerator();

        $ref1 = $generator->generate([]);
        $ref2 = $generator->generate([]);

        $this->assertFalse($ref1 === $ref2);
    }
}
