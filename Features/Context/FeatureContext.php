<?php

namespace Matks\Bundle\CustomerSupportBundle\Features\Context;


use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class FeatureContext implements KernelAwareContext
{
    use CustomerSupportCategorySteps;
    use CustomerSupportTicketSteps;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel HttpKernel instance
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Returns HttpKernel instance.
     *
     * @return KernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Returns HttpKernel service container.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * Return the object persistence manager
     *
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        return $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @BeforeSuite
     *
     * @param BeforeSuiteScope $event
     */
    public static function clearCache(BeforeSuiteScope $event)
    {
        $tempDir = is_writable(__DIR__ . '/../../build/tmp') ? __DIR__ . '/../../build/tmp/' : sys_get_temp_dir() . '/MatksCustomerSupportBundle/';
        $fs = new Filesystem();
        try {
            $fs->remove($tempDir . '/*');
        } catch (IOException $e) {
            throw new \Exception(sprintf('Unable to clear the test application cache at "%s"', $tempDir));
        }
    }

    /**
     * @BeforeScenario
     */
    public function buildSchema($event)
    {
        $entityManager = $this->getEntityManager();
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $tool = new SchemaTool($entityManager);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
    }

    /**
     * @AfterStep
     *
     * Clear doctrine entity manager
     */
    public function clearEntityManager()
    {
        $this->getEntityManager()->clear();
    }
}
