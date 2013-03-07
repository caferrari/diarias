<?php

namespace Common\Model;

abstract class Document
{

    public function __construct(array $data = null)
    {
        if ($data) {
            $this->setData($data);
        }
    }

    public function setData($data)
    {
        foreach ($data as $k => $v) {
            $this->__set($k, $v);
        }
    }

    public function getData()
    {
        return get_object_vars($this);
    }

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