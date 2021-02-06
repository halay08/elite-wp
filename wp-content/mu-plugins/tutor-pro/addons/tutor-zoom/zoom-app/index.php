<?php
require_once __DIR__ . '/vendor/autoload.php';

$zoom = new \Zoom\ZoomAPI('AAAAA', 'BBBBB');


var_dump($zoom->createUser() );
exit();

