<?php

namespace Matks\Bundle\CustomerSupportBundle\Tests\Units\Reference;

use Matks\Bundle\CustomerSupportBundle\Reference;
use PHPUnit_Framework_TestCase;

use Matks\Bundle\CustomerSupportBundle\Tests\Units\Util;

class TimeReferenceGeneratorTest extends PHPUnit_Framework_TestCase
{
    use Util\TestUtils;

    public function testGenerate()
    {
        $generator = new Reference\TimeReferenceGenerator();

        $ref1 = $generator->generate([]);
        $ref2 = $generator->generate([]);

        $this->assertFalse($ref1 === $ref2);
    }
}
