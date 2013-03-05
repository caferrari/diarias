<?php

namespace Diarias\Model\Repository;

use Common\Model\DocumentRepository,
    \SplFileObject;

class Colaborador extends DocumentRepository
{

    public function importFromTxt($file)
    {

        if (!file_exists($file)) {
            throw new \InvalidArgumentException('Arquivo não encontrado');
        }

        $fp = fopen($file, 'r');
        stream_filter_append($fp, 'convert.iconv.ISO-8859-1/UTF-8', STREAM_FILTER_READ);

        $fields = array('ÓRGÃO' => 'orgao', 'MATRICULA' => 'matricula', 'NOME' => 'nome',
            'LOTAÇÃO' => 'lotacao', 'CARGO EFETIVO' => 'cargo_efetivo', 'CARGO EM COMISSÃO' => 'cargo_comissao',
            'SÍMBOLO' => 'simbolo', 'AGENCIA' => 'agencia', 'CONTA CORRENTE' => 'conta',
            'BANCO - PAGAMENTO' => 'banco', 'IDENTIDADE NUMERO' => 'rg', 'IDENTIDADE ÓRGÃO' => 'rg_orgao',
            'CPF' => 'cpf', 'INDENTIDADE UF' => 'rg_uf');

        $headers = fgetcsv($fp, 4096, ';');

        $documentFields = array_values($fields);
        $requiredFields = array_keys($fields);

        $headerMap = array();
        foreach ($requiredFields as $header) {
            $index = array_search($header, $headers);
            if ($index === false) {
                throw new \RuntimeException("Arquivo enviado não tem o campo \"$header\"");
            }
            $headerMap[$documentFields[$index]] = array_search($header, $requiredFields);
        }

        while ($line = fgetcsv($fp, 4096, ';')) {
            $data = array();
            foreach ($headerMap as $k => $v) {
                $data[$k] = $line[$v];
            }
            $colaborador = $this->getDocument($data);
        }
        fclose($fp);

        return true;
    }

}