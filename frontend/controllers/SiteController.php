<?php

namespace frontend\controllers;

use frontend\modules\app\models\TbScanQr;
use homer\user\models\Account;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use dektrium\user\helpers\Password;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\modules\app\models\TbLuckyDraw;
use frontend\modules\app\models\TbItemRewards;
use homer\user\models\Profile;
use homer\user\models\RegistrationForm;
use homer\user\models\User;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'scanqr', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        $account = Account::findOne(['user_id' => Yii::$app->user->id, 'provider' => 'line']);
        $dataQr = TbScanQr::find()->where(['user_id' => Yii::$app->user->id])->all();
        return $this->render('index', [
            'account' => $account,
            'dataQr' => $dataQr
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionAward()
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        $rewrads = TbLuckyDraw::find()->where(['publish' => 1])->orderBy('created_at asc')->all();
        return $this->render('rewrads', [
            'rewrads' => $rewrads
        ]);
    }

    public function actionRewradDetail($id)
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        $model = TbLuckyDraw::findOne($id);
        $rewrads = TbItemRewards::find()->where(['rewards_id' => $model['rewards_id']])->all();

        return $this->render('about', [
            'model' => $model,
            'rewrads' => $rewrads,
        ]);
    }
    public function actionDetailScanQrcode()
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        return $this->render('_detail_qrcode', []);
    }

    public function actionScanqr()
    {
        $this->layout = '@homer/views/layouts/_landing_page';
        return $this->render('scanqr');
    }

    public function actionRegister()
    {
        $this->layout = '@homer/views/layouts/main-login';
        $request = Yii::$app->request;
        if($request->isPost) {
            $posted = $request->post('User');
            $user = User::findOne(['email' => $posted['email']]);
            if(!empty($user)) {
                throw new HttpException(400, 'อีเมลนี้ถูกใช้ลงทะเบียนแล้ว กรุณาใช้อีเมลใหม่ค่ะ');
            }
        }
        /** @var RegistrationForm $model */
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'connect',
            'password' => Password::generate(8)
        ]);

        $profile = \Yii::createObject(Profile::className());
        $profile->scenario = 'connect';
        $profile->setAttributes(\Yii::$app->request->post('Profile'));
        $user->setProfile($profile);

        if ($user->load(\Yii::$app->request->post()) && $user->create()) {
            $auth = \Yii::$app->authManager;
            $authorRole = $auth->getRole('user');
            $auth->assign($authorRole, $user->getId());

            $account = \Yii::createObject([
                'class'      => Account::className(),
                'provider'   => 'line',
                'client_id'  => $request->post('client_id'),
                'data'       => json_encode($request->post('data'))
            ]);
    
            $account->setAttributes([
                'username' => $user->email,
                'email'    => $user->email,
            ], false);

            $account->save(false);

            $account->connect($user);

            return $this->asJson([
                'message' => 'successfully'
            ]);
        }

        return $this->render('register', [
            'user'  => $user,
            'profile' => $profile,
        ]);
    }
}
