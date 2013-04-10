<?php
return array(
    'modules' => array(
        'ZendDeveloperTools',
        'Diarias',
        'Test',
        'Common',
        'DoctrineModule',
        'DoctrineMongoODMModule'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    )
);
