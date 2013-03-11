<?php

namespace Test;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;
use Doctrine\ORM\EntityManager;

class ModelTestCase extends TestCase
{

    /**
     * @var EntityManager
     */
    protected $dm;

    public function tearDown()
    {
        parent::tearDown();
        $this->getDm()->getConnection()->dropDatabase('mongodb_test');
    }

    public function getDm()
    {
        if (isset($this->dm)) {
            return $this->dm;
        }
        return $this->dm = $this->application->getServiceManager()->get('doctrine.documentmanager.odm_default');
    }
}