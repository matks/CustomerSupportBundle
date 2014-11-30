<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * Appkernel for tests
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        date_default_timezone_set('UTC');

        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Matks\Bundle\CustomerSupportBundle\CustomerSupportBundle(),
        );
    }

    /**
     * @return null
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->guessTempDirectoryFor('cache');
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return $this->guessTempDirectoryFor('logs');
    }

    private function guessTempDirectoryFor($dirname)
    {
        return is_writable(__DIR__ . '/../../../../build/tmp') ? __DIR__ . '/build/tmp/' . $dirname : sys_get_temp_dir() . '/MatksCustomerSupportBundle/' . $dirname;
    }
}
