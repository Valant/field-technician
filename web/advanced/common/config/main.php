<?php
    return [
        'vendorPath' => dirname( dirname( __DIR__ ) ) . '/vendor',
        'components' => [
            'cache' => [
                'class' => 'yii\caching\FileCache',
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => false,
            ],
            'urlManagerFrontend' => [
                'class' => 'yii\web\urlManager',
                'baseUrl' => 'http://api.afa.valant.com.ua',
                'enablePrettyUrl' => true,
                'showScriptName' => false,
            ],
        ]
    ];
