<?php
$ENV = parse_ini_file('.env');

$sqlHost = $ENV['MYSQL_HOST'];
$sqlUser = $ENV['MYSQL_USER'];
$sqlPass = $ENV['MYSQL_PASSWORD'];
$sqlName = $ENV['MYSQL_DATABASE'];

$sqlConnect = new mysqli($sqlHost, $sqlUser, $sqlPass, $sqlName);
$sqlConnect->set_charset("utf8");