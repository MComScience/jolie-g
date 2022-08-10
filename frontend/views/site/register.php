<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use homer\user\models\TbSex;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use homer\user\models\TbProvince;
use homer\widgets\Icon;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $model
 * @var dektrium\user\models\Account $account
 */

$this->title = Yii::t('user', 'ลงทะเบียน');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/waitMe.min.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::class],
]);
?>
<div class="row">
    <div class="col-md-12">
        <div class="text-center m-b-md">
            <h3>ลงทะเบียน</h3>
            <small><?= Yii::$app->name ?></small>
        </div>
        <div class="hpanel">
            <div class="panel-body">
                <br>
                <?php $form = ActiveForm::begin([
                    'id' => 'connect-account-form',
                    'fieldConfig' => [
                        'showLabels' => false,
                    ],
                ]); ?>

                <div class="form-group">
                    <?= Html::activeLabel($profile, 'sex_id', ['class' => 'col-sm-3 control-label']) ?>
                    <div class="col-sm-6">
                        <?= $form->field($profile, 'sex_id')->radioList(ArrayHelper::map(TbSex::find()->asArray()->all(), 'sex_id', 'sex_name'), ['inline' => true]) ?>
                    </div>
                </div>

                <?= $form->field($profile, 'first_name', [
                    'addon' => ['prepend' => ['content' => Icon::show('user', ['framework' => Icon::PE7S])]]
                ])->textInput([
                    'placeholder' => $profile->getAttributeLabel('first_name')
                ]) ?>

                <?= $form->field($profile, 'last_name', [
                    'addon' => ['prepend' => ['content' => Icon::show('user', ['framework' => Icon::PE7S])]]
                ])->textInput([
                    'placeholder' => $profile->getAttributeLabel('last_name')
                ]) ?>

                <?= $form->field($profile, 'birthday', [
                    'addon' => ['prepend' => ['content' => Icon::show('date', ['framework' => Icon::PE7S])]]
                ])->widget(MaskedInput::className(), [
                    'mask' => '99/99/9999',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => $profile->getAttributeLabel('birthday')
                    ],
                ])->hint('<small class="text-danger">โปรดระบุปีเป็น พ.ศ.</small>') ?>

                <?= $form->field($profile, 'tel', [
                    'addon' => ['prepend' => ['content' => Icon::show('phone', ['framework' => Icon::PE7S])]]
                ])->widget(MaskedInput::className(), [
                    'mask' => '999-999-9999',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => $profile->getAttributeLabel('tel')
                    ],
                ]) ?>

                <?= $form->field($profile, 'province', [
                    'addon' => ['prepend' => ['content' => Icon::show('address-book-o')]]
                ])->widget(Select2::classname(), [
                    'language' => 'th',
                    'data' => ArrayHelper::map(TbProvince::find()->asArray()->all(), 'province_id', 'province_name'),
                    'options' => ['placeholder' => 'เลือกจังหวัด...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'theme' => Select2::THEME_BOOTSTRAP,
                ]); ?>

                <?= $form->field($user, 'email', [
                    'addon' => ['prepend' => ['content' => Icon::show('envelope-o')]]
                ])->textInput([
                    'placeholder' => $user->getAttributeLabel('email'),
                    'type' => 'email',
                    'maxlength' => 255
                ]) ?>

                <?php /* $form->field($model, 'username',[
                    'addon' => ['prepend' => ['content' => Icon::show('user',['framework' => Icon::PE7S])]]
                ])->textInput([
                    'placeholder' => $model->getAttributeLabel('username'),
                ])*/ ?>

                <?= Html::activeHiddenInput($user, 'username'); ?>

                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs(
    <<<JS
$('#user-email').on('keyup', function(){
    $('#user-username').val($(this).val());
});
JS
);
?>


<?php
$this->registerJsFile(
    'https://static.line-scdn.net/liff/edge/2/sdk.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '//cdn.jsdelivr.net/npm/sweetalert2@11',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    'https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '//unpkg.com/axios/dist/axios.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
    '@web/js/waitMe.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJs(<<<JS
$('#back-to-login').hide()
liff
    .init({ 
        liffId: "1552736042-KqeVvaMw",
        // withLoginOnExternalBrowser: true,
    })
    .then(() => {
        if (liff.isLoggedIn()) {
            const email = liff.getDecodedIDToken().email
            if(email) {
                $('#user-email').val(email)
                $('#user-username').val(email)
            }
            liff
                .getProfile()
                .then((profile) => {
                    localStorage.setItem('profile', JSON.stringify(profile))
                    getProfile()
                })
        } else if (!liff.isLoggedIn()) {
            liff.login({ redirectUri: "https://jolie-g.info/site/register" })
        }
    })
    .catch((err) => {
        console.log(err)
    })

    var \$form = $('#connect-account-form');
    \$form.on('beforeSubmit', function() {
        var formData = \$form.serializeArray().reduce(function(a, x) { a[x.name] = x.value; return a; }, {})
        var profile = JSON.parse(localStorage.getItem('profile'))
        $("#connect-account-form").waitMe({
			effect: "roundBounce",
			text: "",
			bg: "rgba(255,255,255,0.7)",
			color: "#000",
			maxSize: "",
			waitTime: -1,
			textPos: "vertical",
			fontSize: "",
			source: "",
			onClose: function () {},
		})

        $.ajax({
            url: \$form.attr('action'),
            type: 'POST',
            data: Object.assign({}, formData, {
                client_id: profile.userId,
                data: profile
            }),
            success: function (data) {
                $("#connect-account-form").waitMe("hide")
                Swal.fire({
                    icon: 'success',
                    title: 'ลงทะเบียนสำเร็จ',
                    text: 'กรุณารอสักครู่กำลังนำคุณไปสู่หน้าหลัก',
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.replace('/site/scanqr')
                    }
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#connect-account-form").waitMe("hide")
                Swal.fire({
                    icon: "warning",
                    title: "เกิดข้อผิดพลาด!",
                    text: _.get(jqXHR, "responseJSON.data.message", errorThrown),
                })
            }
        });
        return false; // prevent default submit
    });

    async function getProfile () {
		try {
			const idToken = liff.getIDToken()
			const profile = await liff.getProfile()
			// const email = liff.getDecodedIDToken().email
			let response = await axios.get(`/v1/user/me?id_token=${idToken}`)
			if (response.user && response.account) {
				window.location.replace("/site/scanqr")
			}
		} catch (error) {
			Swal.fire({
				icon: "error",
				title: "เกิดข้อผิดพลาด!",
				text: error.message,
			})
		}
	},
JS
);
?>