<?php

namespace Diarias\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Common\Model\Document;

/** @ODM\Document(collection="colaborador") */
class Colaborador extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\String */
    protected $nome;

    /** @ODM\String */
    protected $email;

    /** @ODM\Int */
    protected $matricula;

    /** @ODM\String */
    protected $cpf;

    public function setNome($nome) {
        $this->nome = mb_strtoupper($nome);
    }

    public function setCpf($cpf) {
        if (!is_numeric($cpf) || strlen($cpf) != 11) {
            throw new \InvalidArgumentException("CPF inválido");
        }
        $this->cpf = $cpf;
    }
}
