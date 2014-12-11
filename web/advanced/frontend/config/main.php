<?php
    $params = array_merge(
        require( __DIR__ . '/../../common/config/params.php' ),
        require( __DIR__ . '/../../common/config/params-local.php' ),
        require( __DIR__ . '/params.php' ),
        require( __DIR__ . '/params-local.php' )
    );

    return [
        'id'                  => 'app-frontend',
        'basePath'            => dirname( __DIR__ ),
        'bootstrap'           => [ 'log' ],
        'controllerNamespace' => 'frontend\controllers',
        'components'          => [
            'user'         => [
                'identityClass'   => 'common\models\User',
                'enableAutoLogin' => true,
            ],
            'log'          => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets'    => [
                    [
                        'class'  => 'yii\log\FileTarget',
                        'levels' => [ 'error', 'warning' ],
                    ],
                ],
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'request'    => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => 'y66p--lh5kuVhVbWG8Na0UD6tTK2toqP',
            ],
            'urlManager' => [
                'enablePrettyUrl'     => true,
                'enableStrictParsing' => false,
                'showScriptName'      => false,
                'rules'               => [
                    [
                        'class'      => 'yii\rest\UrlRule',
                        'controller' => [ 'taskattachment' => 'taskattachment', 'task' => 'task', 'taskhistory' =>'taskhistory', 'user' => 'user', 'ticket'=>'ticket', 'vendor'=>'vendor']
                    ],
                ],
            ]
        ],
        'params'              => $params,
    ];
