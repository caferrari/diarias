<?php

namespace Diarias;

use Test\TestCase;

class ColaboradorTest extends TestCase
{

    public function testSeClasseColaboradorExiste()
    {
        $this->assertTrue(class_exists('Diarias\Document\Colaborador'));
        $c = new Document\Colaborador;
        $this->assertTrue(get_class($c) == 'Diarias\Document\Colaborador');
    }

    /**
      * @dataProvider providerCampos
      */
    public function testCampos($campo, $valor) {
        $c = new Document\Colaborador;

        $campos = get_object_vars($c);

        try {
            $c->$campo = $valor;
            $this->assertEquals($valor, $c->$campo);
        } catch (\InvalidArgumentException $e) {
            $this->fail("Propriedade \"$campo\" não existe");
        }
    }

    /**
      * @dataProvider providerNomes
      */
    public function testSeConverteNomesParaMaiusculas($nomeOriginal, $nomeEsperado) {
        $c = new Document\Colaborador;
        $c->nome = $nomeOriginal;
        $this->assertEquals($nomeEsperado, $c->nome);
    }

    public function testSeInsereColaboradorNoMongo()
    {
        $dm = $this->getDm();

        $collection = $dm->getDocumentCollection('Diarias\Document\Colaborador');
        $collection->drop();

        $c = new Document\Colaborador;

        $c->nome = 'Carlos André Ferrari';
        $c->email = 'caferrari@gmail.com';

        $dm->persist($c);
        $dm->flush();

        $this->assertEquals(1, $collection->count());

        $r = $dm->getRepository('Diarias\Document\Colaborador');
        $obj = $r->findOneById($c->id);
        $this->assertEquals($obj, $c);
    }

    public function providerNomes() {
        return array(
            array('carlos andré ferrari', 'CARLOS ANDRÉ FERRARI'),
            array('carlos AndRé Ferrari', 'CARLOS ANDRÉ FERRARI'),
            array('áéíóú bla', 'ÁÉÍÓÚ BLA')
        );
    }

    public function providerCampos() {
        return array(
            array('id', 1),
            array('nome', 'FULANO'),
            array('matricula', 123)
        );
    }


}