<?php

namespace Test;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\Mvc\MvcEvent;

class ModelTestCase extends TestCase
{

    protected $service = 'doctrine.documentmanager.odm_default';

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
        return $this->dm = $this->application->getServiceManager()->get($this->service);
    }

    public function getDmMock()
    {

        $dbMock = $this->getMock(
            'Doctrine\MongoDB\Database',
            array('dropCollection'),
            array(),
            '',
            array()
        );

        $dmMock = $this->getMock(
            'Doctrine\ODM\MongoDB\DocumentManager',
            array('flush', 'persist', 'refresh', 'getDocumentDatabase'),
            array(),
            '',
            array()
        );

        $dmMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));

        $dmMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        $dmMock->expects($this->any())
            ->method('refresh')
            ->will($this->returnValue(null));

        $dbMock->expects($this->any())
            ->method('dropCollection')
            ->will($this->returnValue(null));


        $dmMock->expects($this->any())
            ->method('getDocumentDatabase')
            ->will($this->returnValue($dbMock));

        return $dmMock;
    }
}