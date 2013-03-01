<?php

namespace Diarias\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document(collection="orgao") */
class Orgao
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $nome;

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
        if (!is_string($nome) || empty($nome)) {
            throw new \InvalidArgumentException("Nome deve ser String");
        }

        if (strlen($nome) < 10) {
            throw new \InvalidArgumentException("Nome deve conter pelo menos 10 caracteres");
        }
        $this->nome = mb_strtoupper($nome);
    }

}
