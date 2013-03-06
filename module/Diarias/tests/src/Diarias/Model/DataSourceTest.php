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
    public function testSeNaoPermiteCaminhosInvalidos() {
        $ds = new DataSource('/tmp/vaisefuder');
    }

    public function testSeAbreArquivo() {
        $file = __DIR__ . '/../../../resources/colaboradores.txt';
        $ds = new DataSource($file);

        $this->assertInstanceOf('Diarias\Model\DataSource', $ds);
    }

    public function testSeLeUmaLinhaComoArray()
    {
        $file = __DIR__ . '/../../../resources/colaboradores.txt';
        $ds = new DataSource($file);
        $row = $ds->getRow();

        $this->assertTrue(is_array($row));
        $this->assertEquals(14, count($row));

        $this->assertEquals(
            array("ÓRGÃO", "MATRICULA", "NOME", "LOTAÇÃO", "CARGO EFETIVO", "CARGO EM COMISSÃO", "SÍMBOLO",
            "AGENCIA", "CONTA CORRENTE", "BANCO - PAGAMENTO", "IDENTIDADE NUMERO", "IDENTIDADE ÓRGÃO",
            "INDENTIDADE UF", "CPF"),
            $row
        );
    }

    public function testSeLeTodasAsLinhas() {
        $file = __DIR__ . '/../../../resources/colaboradores.txt';
        $ds = new DataSource($file);

        $x = 0;
        while ($row = $ds->getRow()) {
            $x++;
            $this->assertEquals(14, count($row));
        }

        $this->assertEquals(67, $x);

        $this->assertTrue($ds->close());
    }

}