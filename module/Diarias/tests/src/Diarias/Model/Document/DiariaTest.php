<?php

namespace Diarias\Model\Document;

use Test\ModelTestCase;

class DiariaTest extends ModelTestCase
{

    public function testSeClasseDiariasExiste()
    {
        $this->assertTrue(class_exists('Diarias\Model\Document\Diaria'));
    }

}