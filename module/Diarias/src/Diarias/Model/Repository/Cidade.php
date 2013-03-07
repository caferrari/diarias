<?php

namespace Diarias\Model\Repository;

use Common\Model\DocumentRepository,
    Diarias\Model\DataSource,
    \ZipArchive;

class Cidade extends DocumentRepository
{

    public function importCidades()
    {

        copy('https://github.com/diegoholiveira/br-estados-cidades/archive/master.zip', '/tmp/cidades.zip');

        $zip = new ZipArchive;
        if (false === $zip->open('/tmp/cidades.zip')) {
            return false;
        }
        $zip->extractTo('/tmp/cidadesJson/');
        $zip->close();

        $files = glob('/tmp/cidadesJson/br-estados-cidades-master/data/*.json');

        $cidades = 0;

        $collection = $this->getDm()->getConnection()->selectCollection('cidade');

        var_dump(get_class_methods($collection));

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
                $this->getDm()->persist($cidade);
                $cidades++;
            }
        }

        $this->getDm()->flush();
        return $cidades;
    }

}