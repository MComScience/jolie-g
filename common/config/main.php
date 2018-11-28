<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@homer' => '@common/themes/homer',
        '@homer/user' => '@homer/modules/yii2-user',
        '@Mpdf' => '@common/lib/mpdf/src',
        '@homer/tagsinput' => '@homer/widgets/yii2-tags-input/src',
        '@homer/bootstraptoggle' => '@homer/widgets/yii2-bootstrap-toggle/src',
        '@mcomscience/datepicker' => '@homer/widgets/yii2-datepicker-thai/src',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'JOLIE-G',
    # ตั้งค่าการใช้งานภาษาไทย (Language)
    'language' => 'th', // ตั้งค่าภาษาไทย
    # ตั้งค่า TimeZone ประเทศไทย
    'timeZone' => 'Asia/Bangkok', // ตั้งค่า TimeZone
    //'sourceLanguage' => 'th-TH',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'defaultTimeZone' => 'Asia/Bangkok',
            'timeZone' => 'Asia/Bangkok'
        ],
        'keyStorage' => [
            'class' => '\common\components\keystorage\KeyStorage',
        ],
        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en' => 'English (US)', 'th' => 'ภาษาไทย'],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'db' => 'db',
                    'sourceMessageTable' => '{{%i18n_source_message}}',
                    'messageTable' => '{{%i18n_message}}',
                    'enableCaching' => YII_DEBUG ? false : true,
                    'cachingDuration' => 3600,
                    'on missingTranslation' => ['common\modules\translation\Module', 'missingTranslation']
                ],
            ],
        ],
    ],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enableFlashMessages' => true,
            'enableGeneratingPassword' => false,
            'enableConfirmation' => true,
            'enablePasswordRecovery' => true,
            'enableAccountDelete' => false,
            'enableRegistration' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],
            'urlPrefix' => 'auth',
            'modelMap' => [
                'User' => 'homer\user\models\User',
                'Profile' => 'homer\user\models\Profile',
                'RegistrationForm' => 'homer\user\models\RegistrationForm',
                'Account' => 'homer\user\models\Account',
            ],
            'controllerMap' => [
                'settings' => [
                    'class' => 'homer\user\controllers\SettingsController',
                ],
                'admin' => [
                    'class' => 'homer\user\controllers\AdminController',
                ],
                'registration' => [
                    'class' => 'homer\user\controllers\RegistrationController',
                    'layout' => '@homer/views/layouts/main-login',
                ],
                'recovery' => [
                    'class' => 'homer\user\controllers\RecoveryController',
                    'layout' => '@homer/views/layouts/main-login',
                ],
                'security' => [
                    'class' => 'homer\user\controllers\SecurityController',
                    'layout' => '@homer/views/layouts/main-login',
                ],
            ],
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'top-menu', //'left-menu', 'right-menu' and 'top-menu'
            'menus' => [
                'menu' => null,
                'user' => null, // disable menu
            ],
        ],
        'translation' => [
            'class' => 'common\modules\translation\Module',
        ],
        'file' => [
            'class' => 'common\modules\file\Module',
        ],
        'system' => [
            'class' => 'common\modules\system\Module',
        ],
        'menu' => [
            'class' => 'common\modules\menu\Module',
        ],
        'webhook' => [
            'class' => 'common\modules\webhook\Module',
        ],
        'app' => [
            'class' => 'frontend\modules\app\Module',
        ],
        'pdfjs' => [
            'class' => 'yii2assets\pdfjs\Module',
        ],
    ],
];
