<?php

namespace Common\Model;

use Doctrine\ODM\MongoDB\DocumentRepository as ODMDocumentRepository,
    Doctrine\ODM\MongoDB\UnitOfWork,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\ODM\MongoDB\Mapping\ClassMetadata;


abstract class DocumentRepository extends ODMDocumentRepository
{

    public function __construct(DocumentManager $dm, UnitOfWork $uow = null, ClassMetadata $class = null) {
        if (!is_null($uow)) {
            parent::__construct($dm, $uow, $class);
        }
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