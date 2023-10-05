<?php

use Fuel\Core\Autoloader;

Autoloader::add_namespace('Anstech\Form', __DIR__ . '/classes/');
Autoloader::add_classes([
    'Anstech\FormHelper' => __DIR__ . '/classes/formhelper.php',
]);
