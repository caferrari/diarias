<?php

namespace Diarias\Model\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM,
    Common\Model\Document;

/** @ODM\Document(collection="valor") */
class Valor extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\Float */
    protected $valor_capital_estado;

    /** @ODM\Float */
    protected $valor_capital;

    /** @ODM\Float */
    protected $valor_interior;

    /** @ODM\Collection(strategy="pushAll") */
    protected $cargos = array();
}
