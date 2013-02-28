<?php

namespace Diarias;

use Test\TestCase;

class ModuleTest extends TestCase
{

    public function test_se_a_classe_mongoClient_existe()
    {
        $this->assertTrue(class_exists("\\MongoClient"));
    }

}