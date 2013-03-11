<?php

namespace Diarias\Model\Document;

use Test\ModelTestCase;

class OrgaoTest extends ModelTestCase
{

    public function testSeClasseOrgaoExiste()
    {
        $this->assertTrue(class_exists('Diarias\Model\Document\Orgao'));
    }

    /**
      * @dataProvider providerCampos
      */
    public function testCampos($campo, $valor) {
        $c = new Orgao;
        $campos = get_object_vars($c);

        try {
            $c->$campo = $valor;
            $this->assertEquals($valor, $c->$campo);
        } catch (\InvalidArgumentException $e) {
            $this->fail("Propriedade \"$campo\" não existe");
        }
    }

    public function testSeInsereOrgaoNoMongo()
    {
        $dm = $this->getDm();

        $collection = $dm->getDocumentCollection('Diarias\Model\Document\Orgao');

        $c = new Orgao;
        $c->nome = 'Secretaria da Comunicação';
        $dm->persist($c);
        $dm->flush();

        $this->assertEquals(1, $collection->count());

        $c = new Orgao;
        $c->nome = 'Secretaria da Educação';
        $dm->persist($c);
        $dm->flush();

        $this->assertEquals(2, $collection->count());

        $r = $dm->getRepository('Diarias\Model\Document\Orgao');
        $obj = $r->findOneById($c->id);
        $this->assertEquals($obj, $c);
    }

    /**
      * @dataProvider providerNomesInvalidos
      * @expectedException InvalidArgumentException
      */
    public function testSeAceitaNomesInvalidos($nome)
    {
        $c = new Orgao;
        $c->nome = $nome;
    }

    public function providerCampos()
    {
        return array(
            array('id', 1),
            array('nome', 'SECRETARIA DA COMUNICAÇÃO SOCIAL'),
        );
    }

    public function providerNomesInvalidos()
    {
        return array(
            array(''),
            array(123),
            array(array()),
            array('caractere'),
            array(null),
            array(false)
        );
    }

}