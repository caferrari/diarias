<?php

namespace Diarias\Model\Repository;

use Common\Model\DocumentRepository;

class Valor extends DocumentRepository
{

    public function insert(array $data)
    {
        $document = $this->getDocument($data);

        $this->clearCargos($document->cargos);

        $this->getDm()->persist($document);
        $this->getDm()->flush($document);

        return $document;
    }

    private function clearCargos(array $cargos)
    {
        $this->getDm()->createQueryBuilder($this->getDocumentClass())
            ->update()
            ->multiple(true)
            ->field('cargos')->pullAll($cargos)
            ->getQuery()
            ->execute();
    }

    public function getCargos() {
        $rs = $this->getDm()->getRepository($this->getDocumentClass())->findAll();

        $cargos = array();

        foreach ($rs as $item) {
            $cargos = array_merge($cargos, $item->cargos);
        }
        $cargos = array_unique($cargos);

        sort($cargos);

        return $cargos;
    }

}