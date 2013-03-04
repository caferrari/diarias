<?php

namespace Common\Model;

use Doctrine\ODM\MongoDB\DocumentRepository as ODMDocumentRepository,
    Doctrine\ODM\MongoDB\DocumentManager;

abstract class DocumentRepository extends ODMDocumentRepository
{

    protected $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function insert(array $data)
    {
        $document = $this->getDocument($data);
        $this->getDm()->persist($document);
        $this->getDm()->flush($document);
        return $document;
    }

    public function getDm()
    {
        return $this->dm;
    }

    public function getDocument(array $data) {
        $class = str_replace('\\Repository\\', '\\Document\\', get_called_class());
        return new $class($data);
    }

}