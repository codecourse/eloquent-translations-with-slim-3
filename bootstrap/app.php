<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',

        'app' => [
            'name' => getenv('APP_NAME')
        ],

        'views' => [
            'cache' => getenv('VIEW_CACHE_DISABLED') === 'true' ? false : __DIR__ . '/../storage/views'
        ],

        'translations' => [
            'path' => __DIR__ . '/../lang',
            'fallback' => 'en'
        ]
    ],
]);

$container = $app->getContainer();

$container['translator'] = function ($container) {
    $fallback = $container['settings']['translations']['fallback'];

    $loader = new Illuminate\Translation\FileLoader(
        new Illuminate\Filesystem\Filesystem(), $container['settings']['translations']['path']
    );

    $translator = new Illuminate\Translation\Translator($loader, $_SESSION['lang'] ?? $fallback);
    $translator->setFallback($fallback);

    return $translator;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => $container->settings['views']['cache']
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new App\Views\Extensions\TranslationExtension($container['translator']));

    return $view;
};

require_once __DIR__ . '/../routes/web.php';
