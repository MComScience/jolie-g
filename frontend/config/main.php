<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityCookie' => [
                'name'     => '_frontendIdentity',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    // 'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/http-request.log',
                    'categories' => ['yii\httpclient\*'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'webhook/callback' => 'webhook/line/callback',

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user',
                    'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\d+>',
                    ],
                    'extraPatterns' => [
                        'OPTIONS {id}' => 'options',
                        'POST login' => 'login',
                        'OPTIONS login' => 'options',
                        'POST signup' => 'signup',
                        'OPTIONS signup' => 'options',
                        'POST confirm' => 'confirm',
                        'OPTIONS confirm' => 'options',
                        'POST password-reset-request' => 'password-reset-request',
                        'OPTIONS password-reset-request' => 'options',
                        'POST password-reset-token-verification' => 'password-reset-token-verification',
                        'OPTIONS password-reset-token-verification' => 'options',
                        'POST password-reset' => 'password-reset',
                        'OPTIONS password-reset' => 'options',
                        'GET me' => 'me',
                        'POST me' => 'me-update',
                        'OPTIONS me' => 'options',

                        'POST save-qrcode' => 'save-qrcode',
                        'OPTIONS save-qrcode' => 'options',

                        'GET qrcode-list' => 'qrcode-list',
                        'OPTIONS qrcode-list' => 'options',

                        'GET account' => 'account',
                        'OPTIONS account' => 'options',
                    ]
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'fileStorage' => [
            'class' => 'trntv\filekit\Storage',
            'baseUrl' => '@web/uploads',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@webroot/uploads'
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@homer/views',
                    '@dektrium/user/views' => '@homer/user/views',
                ],
            ],
        ],
        'keyStorage' => [
            'class' => '\common\components\keyStorage\KeyStorage',
        ],
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                /*
                'facebook' => [
                    'class'        => 'dektrium\user\clients\Facebook',
                    'clientId'     => 'APP_ID',
                    'clientSecret' => 'APP_SECRET',
                ],
                'twitter' => [
                    'class'          => 'dektrium\user\clients\Twitter',
                    'consumerKey'    => 'CONSUMER_KEY',
                    'consumerSecret' => 'CONSUMER_SECRET',
                ],
                'google' => [
                    'class'        => 'dektrium\user\clients\Google',
                    'clientId'     => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET',
                ],
                'github' => [
                    'class'        => 'dektrium\user\clients\GitHub',
                    'clientId'     => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET',
                ],
                'vkontakte' => [
                    'class'        => 'dektrium\user\clients\VKontakte',
                    'clientId'     => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET',
                ],
                'yandex' => [
                    'class'        => 'dektrium\user\clients\Yandex',
                    'clientId'     => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ],
                'linkedin' => [
                    'class'        => 'dektrium\user\clients\LinkedIn',
                    'clientId'     => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ],*/
                'line' => [
                    'class' => 'common\clients\Line',
                    'clientId' => '1552736042',//'1583157145',
                    'clientSecret' => 'ac1d7a311e38b3ab902d6629b25a9289',//'b9afa7386fbe9b31d749f52116f07500',
                    'returnUrl' => 'https://jolie-g.info/user/security/auth?authclient=line'
                ],
                /*
                'gitlab' => [
                    'class' => 'yiiauth\gitlab\GitLabClient',
                    'domain'  => 'https://gitlab.com',
                    'clientId' => 'gitlab_client_id',
                    'clientSecret' => 'gitlab_client_secret',
                ],
                'instagram' => [
                    'class' => 'kotchuprik\authclient\Instagram',
                    'clientId' => 'instagram_client_id',
                    'clientSecret' => 'instagram_client_secret',
                ],*/
            ],
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'user/registration/*',
            'user/security/*',
            'user/recovery/*',
            'webhook/*',
            'gii/*',
            'v1/*',
            'app/scan/*'
        ]
    ],
    'params' => $params,
];
