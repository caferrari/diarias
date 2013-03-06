<?php

namespace Diarias\Model;

class DataSource
{

    private $fp;

    public function __construct($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Arquivo $filePath não encontrado!");
        }

        $this->fp = fopen($filePath, 'r');
        stream_filter_append($this->fp, 'convert.iconv.ISO-8859-1/UTF-8', STREAM_FILTER_READ);
    }

    public function getRow() {
        return fgetcsv($this->fp, 4096, ';');
    }

    public function close()
    {
        return fclose($this->fp);
    }

}
