<?php

namespace Diarias\Controller;

use Common\Controller\AbstractController;

class Index extends AbstractController
{

    public function indexAction()
    {

        $cidades = $this->getRepository('Cidade')->findAll();

        return array('data' => $cidades);
    }

}
