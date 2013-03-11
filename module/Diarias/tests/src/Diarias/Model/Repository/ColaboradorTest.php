<?php

namespace Diarias\Model\Repository;

use Test\ModelTestCase;

class ColaboradorTest extends ModelTestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists(__NAMESPACE__ . '\Colaborador'));
    }

    public function testInsertOrUpdate()
    {

        $doc1 = array(
            'nome' => "GABRIELA GLORIA DE CASTRO",
            'orgao' => "SECRETARIA DA COMUNICACAO SOCIAL",
            'lotacao' => "DIRETORIA DE JORNALISMO",
            'cargo_efetivo' => "ANALISTA TECNICO-ADMINISTRATIVO",
            'simbolo' => "",
            'agencia' => "1505-9 COMERCIAL PALMAS",
            'conta' => "428388",
            'banco' => "BANCO DO BRASIL S/A",
            'rg' => "2297939",
            'rg_orgao' => "SSP",
            'rg_uf' => "DF",
            'matricula' => "889772-7",
            'cpf' =>  "737.017.501-49"
        );

        $doc2 = array(
            'nome' => "CHANGED",
            'orgao' => "CHANGED",
            'lotacao' => "CHANGED",
            'cargo_efetivo' => "CHANGED",
            'simbolo' => "",
            'agencia' => "CHANGED",
            'conta' => "CHANGED",
            'banco' => "CHANGED",
            'rg' => "CHANGED",
            'rg_orgao' => "CHANGED",
            'rg_uf' => "CHANGED",
            'matricula' => "1111111-1",
            'cpf' =>  "737.017.501-49"
        );

        $repository = new Colaborador($this->getDm());
        $document = $repository->insertOrUpdate($doc1);

        $this->assertEquals(24, strlen($document->id));

        $repository->desactivateAll();

        $item = $repository->findByCpf($doc1['cpf']);

        $this->assertSame($item, $document);

        $item2 = $repository->insertOrUpdate($doc2);

        $this->assertSame($item, $document);
        $this->assertSame($item2, $document);
        $this->assertSame($item2, $item);
    }

    public function testSeImportaDoTXT()
    {
        $file = __DIR__ . '/../../../../resources/colaboradores-validos-1.csv';
        $repository = new Colaborador($this->getDm());
        $ds = new \Diarias\Model\DataSource($file);
        $this->assertEquals(66, $repository->importFromCsv($ds));
    }

    public function testSeDesabilitaServidoresAntigos() {
        $repository = new Colaborador($this->getDm());

        $file = __DIR__ . '/../../../../resources/colaboradores-validos-1.csv';
        $ds = new \Diarias\Model\DataSource($file);
        $this->assertEquals(66, $repository->importFromCsv($ds));

        $ativos = $repository->listActive();
        $this->assertInstanceOf('Iterator', $ativos);
        $this->assertEquals(66, count(iterator_to_array($ativos)));

        $this->assertEquals(26, count($repository->getCargos()));

        $file = __DIR__ . '/../../../../resources/colaboradores-validos-2.csv';
        $ds = new \Diarias\Model\DataSource($file);
        $this->assertEquals(40, $repository->importFromCsv($ds));

        $ativos = $repository->listActive();
        $this->assertInstanceOf('Iterator', $ativos);
        $this->assertEquals(40, count(iterator_to_array($ativos)));

        $this->assertEquals(20, count($repository->getCargos()));

        $file = __DIR__ . '/../../../../resources/colaboradores-validos-3.csv';
        $ds = new \Diarias\Model\DataSource($file);
        $this->assertEquals(3, $repository->importFromCsv($ds));

        $ativos = $repository->listActive();
        $this->assertInstanceOf('Iterator', $ativos);
        $this->assertEquals(3, count(iterator_to_array($ativos)));

        $this->assertEquals(5, count($repository->getCargos()));
    }

    /**
      * @expectedException RuntimeException
      */
    public function testSeImportaDoTXTInválido()
    {
        $file = __DIR__ . '/../../../../resources/colaboradores-invalidos-1.csv';
        $repository = new Colaborador($this->getDm());
        $ds = new \Diarias\Model\DataSource($file);
        $repository->importFromCsv($ds);
    }

}