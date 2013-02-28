<?php

namespace Diarias;

require_once(__DIR__ . '/../../Test/src/Test/AbstractBootstrap.php');

use Test\AbstractBootstrap;

error_reporting(-1);
ini_set('diaplay_errors', 1);

class Bootstrap extends AbstractBootstrap
{

}

Bootstrap::init();