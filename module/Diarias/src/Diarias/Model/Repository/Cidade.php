<?php

namespace Diarias\Model\Repository;

use Common\Model\DocumentRepository,
    Diarias\Model\DataSource,
    \ZipArchive;

class Cidade extends DocumentRepository
{

    public function importCidades($path)
    {

        $zip = new ZipArchive;
        if (false === ($status = $zip->open($path))) {
            return $status;
        }

        $zip->extractTo('/tmp/cidadesJson/');
        $zip->close();

        $dm = $this->getDm();
        $dm->getDocumentDatabase($this->getDocumentClass())->dropCollection('cidade');

        $files = glob('/tmp/cidadesJson/br-estados-cidades-master/data/*.json');
        $cidades = 0;
        foreach ($files as $file) {
            $estado = json_decode(file_get_contents($file));
            $data = array(
                'estado' => $estado->nome,
                'uf' => $estado->sigla
            );
            foreach ($estado->cidades as $cidade) {
                $data['capital'] = $cidade->nome == $estado->capital;
                $data['nome'] = $cidade->nome;
                $cidade = $this->getDocument($data);
                $dm->persist($cidade);
                if ($cidades++ % 50 == 0) {
                    $dm->flush();
                }
            }
            unlink($file);
        }
        $dm->flush();

        return $cidades;
    }

}