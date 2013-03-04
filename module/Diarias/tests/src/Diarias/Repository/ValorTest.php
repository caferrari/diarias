<?php

namespace Diarias\Repository;

use Test\TestCase;

class ValorTest extends TestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists(__NAMESPACE__ . '\Valor'));
    }

    public function testSeClasseTemAtributoDm()
    {
        $this->assertClassHasAttribute('dm', __NAMESPACE__ . '\Valor');
    }

    public function testSeClassTemMetodoGetDM()
    {
        $repository = new Valor($this->getDm());
        $dm = $repository->getDm();
        $this->assertInstanceOf('Doctrine\ODM\MongoDB\DocumentManager', $dm);
    }

    public function testVerificaInsert()
    {
        $repository = new Valor($this->getDm());

        $data = array(
            'valor_capital_estado' => 125.60,
            'valor_capital' => 115.99,
            'valor_interior' => 50,
            'cargos' => array('DAS-10', 'CPC-IV')
        );
        $result = $repository->insert($data);

        $this->assertInstanceOf('Diarias\Document\Valor', $result);
    }

    public function testSeNaoPermiteDuplicarCargos()
    {
        $data1 = array(
            'valor_capital_estado' => 125.60,
            'valor_capital' => 115.99,
            'valor_interior' => 50,
            'cargos' => array('DAS-10', 'CPC-IV', 'CPC-I')
        );

        $data2 = array(
            'valor_capital_estado' => 125.60,
            'valor_capital' => 115.99,
            'valor_interior' => 50,
            'cargos' => array('DAS-10', 'CPC III', 'DAS-9')
        );

        $repository = new Valor($this->getDm());

        $doc1 = $repository->insert($data1);
        $doc2 = $repository->insert($data2);

        $docs = $this->getDm()->createQueryBuilder('Diarias\Document\Valor')
            ->field('cargos')->equals('DAS-10')
            ->getQuery()
            ->execute();

        $docs = array_values(iterator_to_array($docs));

        $this->assertEquals($doc2->id, $docs[0]->id);
        $this->assertEquals(1, count($docs));

        $this->getDm()->refresh($doc1);
        $this->getDm()->refresh($doc2);

        $this->assertEquals(array('CPC-IV', 'CPC-I'), $doc1->cargos);
        $this->assertEquals(array('DAS-10', 'CPC III', 'DAS-9'), $doc2->cargos);

        $data3 = array(
            'valor_capital_estado' => 125.60,
            'valor_capital' => 115.99,
            'valor_interior' => 50,
            'cargos' => array('DAS-9', 'CPC-I')
        );

        $doc3 = $repository->insert($data3);

        $this->getDm()->refresh($doc1);
        $this->getDm()->refresh($doc2);

        $this->assertEquals(array('CPC-IV'), $doc1->cargos);
        $this->assertEquals(array('DAS-10', 'CPC III'), $doc2->cargos);
    }


}