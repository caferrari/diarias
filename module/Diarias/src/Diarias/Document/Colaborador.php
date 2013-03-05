<?php

namespace Diarias\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM,
    Common\Model\Document;

/** @ODM\Document(collection="colaborador") */
class Colaborador extends Document
{
    /** @ODM\Id */
    protected $id;

    /** @ODM\String */
    protected $nome;

    /** @ODM\String */
    protected $orgao;

    /** @ODM\String */
    protected $lotacao;

    /** @ODM\String */
    protected $cargo_efetivo;

    /** @ODM\String */
    protected $cargo_comissao;

    /** @ODM\String */
    protected $simbolo;

    /** @ODM\String */
    protected $agencia;

    /** @ODM\String */
    protected $conta;

    /** @ODM\String */
    protected $banco;

    /** @ODM\String */
    protected $rg;

    /** @ODM\String */
    protected $rg_orgao;

    /** @ODM\String */
    protected $rg_uf;

    /** @ODM\String */
    protected $email;

    /** @ODM\Int */
    protected $matricula;

    /** @ODM\String */
    protected $cpf;

    public function setNome($nome)
    {
        $this->nome = mb_strtoupper($nome);
    }

    public function setCpf($cpf)
    {
        if (!is_numeric($cpf) || strlen($cpf) != 11) {
            throw new \InvalidArgumentException("CPF inválido");
        }
        $this->cpf = $cpf;
    }
}
