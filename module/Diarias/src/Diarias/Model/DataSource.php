<?php

namespace Diarias\Model;

class DataSource
{

    private $fp;
    private $map;

    public function __construct($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Arquivo $filePath não encontrado!");
        }

        $this->fp = fopen($filePath, 'r');
        stream_filter_append($this->fp, 'convert.iconv.ISO-8859-1/UTF-8', STREAM_FILTER_READ);
    }

    public function setMap(array $map) {
        $this->map = $map;
    }

    private function map(array $line) {
        $data = array();
        foreach ($this->map as $k => $v) {
            $data[$k] = $line[$v];
        }
        return $data;
    }

    public function getRow() {
        if (feof($this->fp)) {
            return false;
        }
        $line = fgetcsv($this->fp, 4096, ';');

        if (array(null) == $line || false === $line) {
            return $this->getRow();
        }

        if ($this->map) {
            return $this->map($line);
        }

        return $line;
    }

    public function close()
    {
        return fclose($this->fp);
    }

}
