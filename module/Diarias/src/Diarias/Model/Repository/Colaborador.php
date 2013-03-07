<?php

namespace Diarias\Model\Repository;

use Common\Model\DocumentRepository,
    Diarias\Model\DataSource;

class Colaborador extends DocumentRepository
{

    private $headerMap;

    private function getHeaderMap(array $headers)
    {

        if (isset($this->headerMap)) {
            return $this->headerMap;
        }

        $fields = array('ÓRGÃO' => 'orgao', 'MATRICULA' => 'matricula', 'NOME' => 'nome',
            'LOTAÇÃO' => 'lotacao', 'CARGO EFETIVO' => 'cargo_efetivo', 'SÍMBOLO' => 'simbolo',
            'AGENCIA' => 'agencia', 'CONTA CORRENTE' => 'conta', 'BANCO - PAGAMENTO' => 'banco',
            'IDENTIDADE NUMERO' => 'rg', 'IDENTIDADE ÓRGÃO' => 'rg_orgao',
            'CPF' => 'cpf', 'INDENTIDADE UF' => 'rg_uf');

        $documentFields = array_values($fields);
        $requiredFields = array_keys($fields);

        $headerMap = array();
        foreach ($requiredFields as $header) {
            $index = array_search($header, $headers);
            if (false === $index) {
                throw new \RuntimeException("Arquivo enviado deve ter o campo \"$header\"");
            }
            $documentIndex = array_search($header, $requiredFields);
            $headerMap[$documentFields[$documentIndex]] = $index;
        }
        return $this->headerMap = $headerMap;
    }

    public function findByCpf($cpf)
    {
        $cpf = preg_replace('@[^0-9]+@', '', $cpf);
        return $this->getDm()->getRepository($this->getDocumentClass())
            ->findOneBy(array('cpf' => $cpf));
    }

    public function insertOrUpdate(array $data)
    {
        $dm = $this->getDm();

        $item = $this->findByCpf($data['cpf']);

        if (!$item) {
            $item = $this->getDocument($data);
            $dm->persist($item);
        } else {
            $dm->refresh($item);
            $item->setData($data);
            $item->active = true;
        }

        $dm->flush($item);
        return $item;
    }

    public function listActive()
    {
        return $this->getDm()->getRepository($this->getDocumentClass())
            ->findBy(array('active' => true));
    }

    public function desactivateAll()
    {
        return $this->getDm()->createQueryBuilder($this->getDocumentClass())
            ->update()
            ->multiple(true)
            ->field('active')->set(false)
            ->getQuery()
            ->execute();
    }

    public function importFromCsv(DataSource $source)
    {
        $headerMap = $this->getHeaderMap($source->getRow());
        $source->setMap($headerMap);
        $this->desactivateAll();
        $lines = 0;
        while ($data = $source->getRow()) {
            $this->insertOrUpdate($data);
            $lines++;
        }
        $source->close();
        return $lines;
    }

    public function getCargos()
    {
        $rs = $this->listActive();
        $cargos = array();
        foreach ($rs as $item) {
            if ($item->cargo_efetivo) {
                $cargos[] = $item->cargo_efetivo;
            }
            if ($item->simbolo) {
                $cargos[] = $item->simbolo;
            }
        }
        $cargos = array_unique($cargos);
        sort($cargos);
        return $cargos;
    }

}