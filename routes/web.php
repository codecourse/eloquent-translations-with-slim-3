<?php

use App\Controllers\HomeController;
use App\Controllers\TranslationController;

$app->get('/', HomeController::class . ':index')->setName('home');
$app->get('/translate/{lang}', TranslationController::class . ':switch')->setName('translate.switch');
