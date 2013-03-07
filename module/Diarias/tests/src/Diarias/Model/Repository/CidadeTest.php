<?php

namespace Diarias\Model\Repository;

use Test\TestCase;

class CidadeTest extends TestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists(__NAMESPACE__ . '\Cidade'));
    }

    public function testSeImportaCidades()
    {
        $repository = new Cidade($this->getDm());
        $this->assertEquals(5507, $repository->importCidades());
    }
}