<?php

require_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$loader = new Composer\Autoload\ClassLoader();
$loader->add('VendingMachine\\', __DIR__.'/src');
$loader->add('Test\\', __DIR__.'/Test');
$loader->register();

