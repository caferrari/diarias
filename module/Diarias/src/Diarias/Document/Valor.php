<?php

namespace Diarias\Document;

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

    public function __set($key, $value)
    {
        $setMethod = "set" . ucfirst($key);
        if (method_exists($this, $setMethod)) {
            $this->$setMethod($value);
            return;
        }

        if (!in_array($key, array_keys(get_object_vars($this)))) {
            throw new \InvalidArgumentException("Propriedade $key não existe");
        }

        $this->$key = $value;
    }

    public function __get($key)
    {
        return $this->$key;
    }

}
