<?php

namespace Test;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;

//chdir(__DIR__.'/../../../../../');

class TestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var EntityManager
     */
    protected $em;
    protected $modules;

    public function setup() {

        parent::setup();

        $pathDir = getcwd()."/";
        $config = include $pathDir.'config/test.config.php';

        $this->serviceManager = new ServiceManager(new ServiceManagerConfig(
                                isset($config['service_manager']) ? $config['service_manager'] : array()
                ));
        $this->serviceManager->setService('ApplicationConfig', $config);
        $this->serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');

        $moduleManager = $this->serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
        $this->routes = array();
        $this->modules = $moduleManager->getModules();
        foreach ($this->filterModules()  as $m) {
            $moduleConfig = include $pathDir.'module/' . ucfirst($m) . '/config/module.config.php';
            if (isset($moduleConfig['router'])) {
                foreach ($moduleConfig['router']['routes'] as $key => $name) {
                    $this->routes[$key] = $name;
                }
            }
        }
        $this->serviceManager->setAllowOverride(true);

        $this->application = $this->serviceManager->get('Application');
        $this->event = new MvcEvent();
        $this->event->setTarget($this->application);
        $this->event->setApplication($this->application)
                ->setRequest($this->application->getRequest())
                ->setResponse($this->application->getResponse())
                ->setRouter($this->serviceManager->get('Router'));

        $this->dm = $this->getDm();
    }

    private function filterModules()
    {
        $array = array();
        foreach($this->modules as $m) {
            if ($m <> "DoctrineMongoODMModule" and $m <> "DoctrineModule" and $m <> "DoctrineORMModule" and $m <> "SONBase" and $m <> "DoctrineDataFixtureModule")
                $array[] = $m;
        }
        return $array;
    }

    public function tearDown() {
        parent::tearDown();
        $this->getDm()->getConnection()->dropDatabase('mongodb_test');
    }

    public function getDm() {
        return $this->dm = $this->application->getServiceManager()->get('doctrine.documentmanager.odm_default');
    }
}