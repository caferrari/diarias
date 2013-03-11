<?php

namespace Diarias\Model\Document;

use Test\ModelTestCase;

class ColaboradorTest extends ModelTestCase
{

    public function testSeClasseColaboradorExiste()
    {
        $this->assertTrue(class_exists('Diarias\Model\Document\Colaborador'));
        $c = new Colaborador;
        $this->assertTrue(get_class($c) == 'Diarias\Model\Document\Colaborador');
    }

    /**
      * @dataProvider providerCampos
      */
    public function testCampos($campo, $valor)
    {
        $c = new Colaborador;

        try {
            $c->$campo = $valor;
            $this->assertEquals($valor, $c->$campo);
        } catch (\InvalidArgumentException $e) {
            $this->fail("Propriedade \"$campo\" não existe");
        }
    }

    /**
      * @dataProvider providerForInvalidCpf
      * @expectedException InvalidArgumentException
      */
    public function testCpfInválido($cpf)
    {
        $c = new Colaborador;
        $c->cpf = $cpf;
    }

    /**
      * @dataProvider providerNomes
      */
    public function testSeConverteNomesParaMaiusculas($nomeOriginal, $nomeEsperado)
    {
        $c = new Colaborador;
        $c->nome = $nomeOriginal;
        $this->assertEquals($nomeEsperado, $c->nome);
    }

    public function testSeInsereColaboradorNoMongo()
    {
        $dm = $this->getDm();

        $collection = $dm->getDocumentCollection('Diarias\Model\Document\Colaborador');

        $c = new Colaborador;

        $c->nome = 'Carlos André Ferrari';
        $c->email = 'caferrari@gmail.com';

        $dm->persist($c);
        $dm->flush();

        $this->assertEquals(1, $collection->count());

        $r = $dm->getRepository('Diarias\Model\Document\Colaborador');
        $obj = $r->findOneById($c->id);
        $this->assertEquals($obj, $c);
    }

    public function providerNomes()
    {
        return array(
            array('carlos andré ferrari', 'CARLOS ANDRÉ FERRARI'),
            array('carlos AndRé Ferrari', 'CARLOS ANDRÉ FERRARI'),
            array('áéíóú bla', 'ÁÉÍÓÚ BLA')
        );
    }

    public function providerCampos()
    {
        return array(
            array('id', 1),
            array('nome', 'FULANO'),
            array('matricula', 123),
            array('cpf', '00217064175')
        );
    }

    public function providerForInvalidCpf()
    {
        return array(
            array(''),
            array(123),
            array('blabla'),
            array('blableblibloblu'),
            array(021706417539),
            array(array()),
            array(new \StdClass)
        );
    }
}