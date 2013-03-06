<?php

namespace Diarias\Model\Repository;

use Common\Model\DocumentRepository,
    Diarias\Model\DataSource;

class Colaborador extends DocumentRepository
{

    public function importFromTxt(DataSource $source)
    {
        $fields = array('ÓRGÃO' => 'orgao', 'MATRICULA' => 'matricula', 'NOME' => 'nome',
            'LOTAÇÃO' => 'lotacao', 'CARGO EFETIVO' => 'cargo_efetivo', 'CARGO EM COMISSÃO' => 'cargo_comissao',
            'SÍMBOLO' => 'simbolo', 'AGENCIA' => 'agencia', 'CONTA CORRENTE' => 'conta',
            'BANCO - PAGAMENTO' => 'banco', 'IDENTIDADE NUMERO' => 'rg', 'IDENTIDADE ÓRGÃO' => 'rg_orgao',
            'CPF' => 'cpf', 'INDENTIDADE UF' => 'rg_uf');

        $headers = $source->getRow();

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

        $colaboradores = array();
        while ($line = $source->getRow()) {
            $data = array();
            foreach ($headerMap as $k => $v) {
                $data[$k] = $line[$v];
            }

            $repository = $this->getDm()->getRepository($this->getDocumentClass());
            $item = $repository->findOneBy(array('cpf' => $data['cpf']));
            if (!$item) {
                $item = $this->getDocument($data);
            } else {
                $item->setData($data);
            }
            $this->getDm()->persist($item);
            $this->getDm()->flush($item);
        }

        $source->close();

        return $colaboradores;
    }

}