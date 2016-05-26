<?php
$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'         => 'test-app',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['fotki'],
    'modules'    => [
        'fotki' => [
            'class'      => 'romkaChev\yandexFotki\Module',
            'login'      => null,
            'oauthToken' => null
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'  => [
            'class'    => null,
            'dsn'      => null,
            'username' => null,
            'password' => null,
            'charset'  => null,
        ],
    ],
    'params'     => $params,
];
