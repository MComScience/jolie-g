<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/11/2561
 * Time: 10:08
 */
use homer\widgets\Icon;
use homer\widgets\MobileMenu;
$action = Yii::$app->controller->action->id;
?>
<?php
echo MobileMenu::widget([
    'items' => [
        [
            'label' => Yii::t('user', 'Account details'),
            'icon' => Icon::show('user',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/user/admin/update', 'id' => $user->id],
            'active' => ($action == 'update') ? true : false,
        ],
        [
            'label' => Yii::t('user', 'Profile details'),
            'icon' => Icon::show('id',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/user/admin/update-profile', 'id' => $user->id],
            'active' => ($action == 'update-profile') ? true : false,
        ],
        [
            'label' => Yii::t('user', 'Information'),
            'icon' => Icon::show('note2',['class' => 'pe-2x','framework' => Icon::PE7S]),
            'url' => ['/user/admin/info', 'id' => $user->id],
            'active' => ($action == 'info') ? true : false,
        ],
    ],
    'options' => [
        'class' => 'hidden-lg hidden-md',
    ],
]);
?>
