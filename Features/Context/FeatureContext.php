<?php

namespace Matks\Bundle\CustomerSupportBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Event\ScenarioEvent;
use Behat\Behat\Event\SuiteEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Behat Feature context main configuration
 *
 * @author Mathieu Ferment <mathieu.ferment@gmail.com>
 */
class FeatureContext extends BehatContext implements KernelAwareInterface
{
    use CustomerSupportCategorySteps;
    use CustomerSupportTicketSteps;

    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

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
     * @return Doctrine\Common\Persistence\ObjectManager
     */
    public function getEntityManager()
    {
        return $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @BeforeSuite
     *
     * @param SuiteEvent $event
     */
    public static function clearCache(SuiteEvent $event)
    {
        $tempDir = is_writable(__DIR__ . '/../../build/tmp') ? __DIR__ . '/../../build/tmp/' : sys_get_temp_dir() . '/MatksCustomerSupportBundle/';
        $fs      = new Filesystem();
        try {
            $fs->remove($tempDir . '/*');
        } catch (IOException $e) {
            throw new \Exception(sprintf('Unable to clear the test application cache at "%s"', $tempDir));
        }
    }

    /**
     * @BeforeScenario
     *
     * @param \Behat\Behat\Event\ScenarioEvent|\Behat\Behat\Event\OutlineExampleEvent $event
     *
     * @return null
     */
    public function buildSchema($event)
    {
        $entityManager = $this->getEntityManager();
        $metadata      = $entityManager->getMetadataFactory()->getAllMetadata();

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

    /**
     * Returns a specific context parameter.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
    }
}
