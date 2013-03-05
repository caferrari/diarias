<?php

namespace Diarias\Repository;

use Test\TestCase;

class ColaboradorTest extends TestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists(__NAMESPACE__ . '\Colaborador'));
    }

    /**
      * @expectedException InvalidArgumentException
      */
    public function testSeAceitaPathInvalido()
    {
        $repository = new Colaborador($this->getDm());
        $file = __DIR__ . '/bla.txt';
        $repository->importFromTxt($file);
    }

    public function testSeImportaDoTXT()
    {
        $file = __DIR__ . '/../../../resources/colaboradores.txt';
        $repository = new Colaborador($this->getDm());
        $this->assertTrue($repository->importFromTxt($file));
    }

}