<?php

$objDb = new PDODatabase();
$tables = $objDb->Query('SHOW TABLES FROM ' . DB_NAME);
$data['module_Title'] = 'List of tables';
$data['tableList'] = $tables;

echo defaultAdminModule($strModuleName, $data);
