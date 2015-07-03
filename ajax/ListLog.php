<?php
include_once('../system/config.php');
include_once('../system/functions.php');
$order='';
$prefix='log02';

$objLog = new Log();

$_data = $objLog->get();

echo json_encode($_data);