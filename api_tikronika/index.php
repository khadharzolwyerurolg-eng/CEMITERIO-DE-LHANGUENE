<?php
session_start();

require_once __DIR__ . '/app/core/init.php';

$app = new App;
$app->loadController();
