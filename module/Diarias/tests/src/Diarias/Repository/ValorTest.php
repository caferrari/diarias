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
        $obj = new Valor($this->getDm());
        $dm = $obj->getDm();
        $this->assertInstanceOf('Doctrine\ODM\MongoDB\DocumentManager', $dm);
    }

    public function testVerificaInsert()
    {
        $obj = new Valor($this->getDm());

        $data = array(
            'valor_capital_estado' => 125.60,
            'valor_capital' => 115.99,
            'valor_interior' => 50,
            'cargos' => array('DAS-10', 'CPC-IV')
        );
        $result = $obj->insert($data);

        $this->assertInstanceOf('Diarias\Document\Valor', $result);
    }


}