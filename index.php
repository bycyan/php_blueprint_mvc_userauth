<?php

session_start();

require_once 'controllers/MainController.php';
require_once 'database/Database.php';

$db = new Database();

$main = new MainController($db);
$main->handleMainFlow();
