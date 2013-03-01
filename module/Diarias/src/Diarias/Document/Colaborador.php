<?php

namespace Diarias\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="colaborador") */
class Colaborador
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $nome;

    /** @ODM\String */
    private $email;

    /** @ODM\Int */
    private $matricula;

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

    public function setNome($nome) {
        $this->nome = mb_strtoupper($nome);
    }
}
