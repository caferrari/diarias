<?php

namespace Diarias\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Colaborador
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $email;

    public function __set($key, $value)
    {
        $this->$key = $value; //$this->valid($key, $value);
    }

    public function __get($key)
    {
        return $this->$key;
    }
}