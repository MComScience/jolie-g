<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/11/2561
 * Time: 20:22
 */
use homer\widgets\Icon;
use homer\widgets\MobileMenu;

$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;
$action = Yii::$app->controller->action->id;
?>
<?php
echo MobileMenu::widget([
    'items' => [
        [
            'label' => Yii::t('menu', 'Home'),
            'icon' => Icon::show('home',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/site/scanqr'],
        ],
        // [
        //     'label' => Yii::t('menu', 'คิวอาร์โค้ดของฉัน'),
        //     'icon' => Icon::show('qrcode',['class' => 'pe-2x']),
        //     'url' => ['/site/index#qrcode'],
        // ],
        [
            'label' => Yii::t('user', 'Profile'),
            'icon' => Icon::show('user',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/user/settings/profile'],
            'active' => ($action == 'profile') ? true : false,
        ],
        /*
        [
            'label' => Yii::t('user', 'Account'),
            'icon' => Icon::show('id',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/user/settings/account'],
            'active' => ($action == 'account') ? true : false,
        ],
        [
            'label' => Yii::t('user', 'Networks'),
            'icon' => Icon::show('global',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/user/settings/networks'],
            'active' => ($action == 'networks') ? true : false,
            'visible' => $networksVisible
        ],*/
    ],
    'options' => [
        'class' => 'hidden-lg hidden-md',
    ],
]);
?>
