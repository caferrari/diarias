<?php

namespace Diarias\Model\Document;

use Test\ModelTestCase;

class WaypointTest extends ModelTestCase
{

    public function testSeClasseWaypointExiste()
    {
        $this->assertTrue(class_exists('Diarias\Model\Document\Waypoint'));
    }

}