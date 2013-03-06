<?php

namespace Diarias\Model\Repository;

use Test\TestCase;

class ColaboradorTest extends TestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists(__NAMESPACE__ . '\Colaborador'));
    }

    public function testSeImportaDoTXT()
    {
        $file = __DIR__ . '/../../../../resources/colaboradores.txt';
        $repository = new Colaborador($this->getDm());
        $ds = new \Diarias\Model\DataSource($file);
        $this->assertTrue(is_array($repository->importFromTxt($ds)));
    }

    public function testSeAtualizaColaboradores() {

    }

}