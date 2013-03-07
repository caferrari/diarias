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

    public function getDm()
    {
        return $this->dm;
    }

    public function getDocument(array $data = null) {
        $class = $this->getDocumentClass();
        return new $class($data);
    }

    public function getDocumentClass()
    {
        return str_replace('\\Repository\\', '\\Document\\', get_called_class());
    }

}