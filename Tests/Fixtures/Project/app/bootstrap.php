<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

if (!file_exists($file = __DIR__ . '/../../../../vendor/autoload.php')) {
    throw new \RuntimeException('Install the dependencies to run the test suite.');
}
$loader = require $file;
$loader->add('Matks\\Bundle', array(realpath(dirname(__FILE__) . '/../src')));

//AnnotationRegistry::registerLoader(array($loader, 'loadClass'));
AnnotationRegistry::registerLoader('class_exists');
