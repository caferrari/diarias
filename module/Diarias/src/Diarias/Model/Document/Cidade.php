<?php

namespace Diarias\Model\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM,
    Common\Model\Document;

/** @ODM\Document(collection="cidade") */
class Cidade extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\String */
    protected $nome;

    /** @ODM\String */
    protected $estado;

    /** @ODM\String */
    protected $uf;

    /** @ODM\Boolean */
    protected $capital = false;
}