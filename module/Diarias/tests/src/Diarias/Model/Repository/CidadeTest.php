<?php

namespace Diarias\Model\Repository;

use Test\ModelTestCase;

class CidadeTest extends ModelTestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists(__NAMESPACE__ . '\Cidade'));
    }

    public function testSeImportaCidades()
    {
        $repository = new Cidade($this->getDmMock());
        $path = getcwd() . '/module/Diarias/tests/resources/cidades.zip';
        $this->assertEquals(39, $repository->importCidades($path));
    }
}