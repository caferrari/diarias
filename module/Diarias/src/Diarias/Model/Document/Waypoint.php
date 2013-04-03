<?php

namespace Diarias\Model\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM,
    Common\Model\Document;

/** @ODM\Document(collection="waypoint") */
class Waypoint extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\Timestamp */
    protected $data;

    /** @ODM\EmbedOne(targetDocument="Diarias\Model\Document\Cidade") */
    protected $cidade;
}