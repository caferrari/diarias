<?php

namespace Diarias\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM,
    Common\Model\Document;

/** @ODM\Document(collection="orgao") */
class Orgao extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\String */
    protected $nome;

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
