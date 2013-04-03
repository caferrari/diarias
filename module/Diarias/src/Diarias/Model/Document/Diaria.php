<?php

namespace Diarias\Model\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM,
    Common\Model\Document;

/** @ODM\Document(collection="cidade") */
class Diaria extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\Int */
    protected $numero;

    /** @ODM\EmbedOne(targetDocument="Diarias\Model\Document\Colaborador") */
    protected $solicitante;

    /** @ODM\EmbedOne(targetDocument="Diarias\Model\Document\Colaborador") */
    protected $colaborador;

    /** @ODM\EmbedOne(targetDocument="Diarias\Model\Document\Colaborador") */
    protected $ordenador;

    /** @ODM\EmbedMany(targetDocument="Diarias\Model\Document\Waypoint") */
    protected $itinerario = array();

    /** @ODM\String */
    protected $uf;

    /** @ODM\Boolean */
    protected $capital = false;
}