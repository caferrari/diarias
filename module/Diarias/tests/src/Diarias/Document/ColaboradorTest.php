<?php

namespace Diarias;

use Test\TestCase;

class ColaboradorTest extends TestCase
{

    public function test_se_insere_no_mongo()
    {
        $dm = $this->getDm();

        $c = new Document\Colaborador;

        $c->name = 'Carlos André Ferrari';
        $c->email = 'caferrari@gmail.com';

        $dm->persist($c);
        $dm->flush();

        $r = $dm->getRepository('Diarias\Document\Colaborador');

        $obj = $r->findOneById($c->id);

        $this->assertEquals($obj, $c);

    }

}