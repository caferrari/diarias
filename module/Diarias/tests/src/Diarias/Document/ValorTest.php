<?php

namespace Diarias\Document;

use Test\TestCase;

class ValorTest extends TestCase
{

    public function testSeClasseOrgaoExiste()
    {
        $this->assertTrue(class_exists('Diarias\Document\Valor'));
    }

    /**
      * @dataProvider providerCampos
      */
    public function testCampos($campo, $valor)
    {
        $c = new Valor;
        $campos = get_object_vars($c);

        try {
            $c->$campo = $valor;
            $this->assertEquals($valor, $c->$campo);
        } catch (\InvalidArgumentException $e) {
            $this->fail("Propriedade \"$campo\" não existe");
        }
    }

    public function testSeInsereValorNoMongo()
    {
        $dm = $this->getDm();

        $collection = $dm->getDocumentCollection('Diarias\Document\Valor');

        $c = new Valor;
        $c->valor_capital_estado = 110.5;
        $c->valor_capital = 110.60;
        $c->valor_interior = 110.55;
        $c->cargos = array('DAS-5', 'DAS-10', 'CPC IV');
        $dm->persist($c);
        $dm->flush();

        $this->assertEquals(1, $collection->count());

        $c = new Valor;
        $c->valor_capital_estado = 110.5;
        $c->valor_capital = 110.60;
        $c->valor_interior = 110.55;
        $c->cargos = array('DAS-6', 'DAS-9', 'CPC III', 'Diretor de Mídias integradas');
        $dm->persist($c);
        $dm->flush();

        $this->assertEquals(2, $collection->count());

        $r = $dm->getRepository('Diarias\Document\Valor');
        $obj = $r->findOneById($c->id);
        $this->assertEquals($obj, $c);
    }

    public function testSeRetornaExceptionAoRepetirCargos()
    {

    }

    public function providerCampos()
    {
        return array(
            array('id', 1),
            array('valor_capital_estado', 125.50),
            array('valor_capital', 125.50),
            array('valor_interior', 125.50),
        );
    }


}