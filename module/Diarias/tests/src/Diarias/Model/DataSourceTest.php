<?php

namespace Diarias\Model;

use Test\TestCase;

class DataSourceTest extends TestCase
{

    public function testSeClasseExiste()
    {
        $this->assertTrue(class_exists('Diarias\Model\DataSource'));
    }

    /**
      * @expectedException RuntimeException
      */
    public function testSeNaoPermiteCaminhosInvalidos()
    {
        $ds = new DataSource('/tmp/arquivoquenaoexiste');
    }

    public function testSeAbreArquivo()
    {
        $file = __DIR__ . '/../../../resources/colaboradores-validos-1.csv';
        $ds = new DataSource($file);
        $this->assertInstanceOf('Diarias\Model\DataSource', $ds);
        $ds->close();
    }

    public function testSeLeUmaLinhaComoArray()
    {
        $file = __DIR__ . '/../../../resources/colaboradores-validos-1.csv';
        $ds = new DataSource($file);
        $row = $ds->getRow();

        $this->assertTrue(is_array($row));
        $ds->close();
    }

    /**
      * @dataProvider providerForDataSource
      */
    public function testSeCarregaCabecalhosCorretamente($arquivo, $cabecalhos) {
        $file = __DIR__ . '/../../../resources/' . $arquivo;
        $ds = new DataSource($file);
        $row = $ds->getRow();
        $this->assertEquals(count($cabecalhos), count($row));
        $this->assertEquals(
            $cabecalhos,
            $row
        );
        $ds->close();
    }

    public function testSeLeTodasAsLinhas()
    {
        $file = __DIR__ . '/../../../resources/colaboradores-validos-1.csv';
        $ds = new DataSource($file);

        $x = 0;
        while ($row = $ds->getRow()) {
            $x++;
            $this->assertEquals(14, count($row));
        }

        $this->assertEquals(67, $x);

        $this->assertTrue($ds->close());
    }

    public function providerForDataSource()
    {
        return array(
            array('colaboradores-validos-1.csv', array("ÓRGÃO", "MATRICULA", "NOME", "LOTAÇÃO", "CARGO EFETIVO", "CARGO EM COMISSÃO", "SÍMBOLO",
            "AGENCIA", "CONTA CORRENTE", "BANCO - PAGAMENTO", "IDENTIDADE NUMERO", "IDENTIDADE ÓRGÃO",
            "INDENTIDADE UF", "CPF")),
            array('colaboradores-invalidos-1.csv', array('NOME','CARGO EFETIVO','CARGO EM COMISSÃO','SÍMBOLO'))
        );
    }

}