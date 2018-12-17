<?php

namespace frontend\modules\app\controllers;

use frontend\modules\app\models\TbProduct;
use frontend\modules\app\models\TbQrcodeSettingsSearch;
use frontend\modules\app\models\TbQrItem;
use homer\widgets\Icon;
use kartik\form\ActiveForm;
use Yii;
use frontend\modules\app\models\TbPaperFormat;
use mcomscience\sweetalert2\SweetAlert2;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\modules\app\models\TbQrcodeSettings;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use common\traits\ModelTrait;

class GenerateQrCodeController extends \yii\web\Controller {

    use ModelTrait;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new TbQrcodeSettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate() {
        $request = \Yii::$app->request;
        $model = new TbQrcodeSettings();
        $dataProvider = new ActiveDataProvider([
            'query' => TbPaperFormat::find(),
        ]);
        if ($model->load($request->post())) {
            if ($request->isAjax && $model->load($request->post())) {
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                if ($model->save()) {
                    return [
                        'success' => true,
                        'url' => Url::to(['/app/generate-qr-code/index']),
                        'message' => 'บันทึกการตั้งค่าเรียบร้อย!'
                    ];
                } else {
                    return [
                        'success' => false,
                        'validate' => ActiveForm::validate($model)
                    ];
                }
            } else {
                $this->createPdf($request->post('TbQrcodeSettings'));
            }
            //\Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('frontend', 'Created successfully!'));
        }
        return $this->render('_form', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id) {
        $request = \Yii::$app->request;
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => TbPaperFormat::find(),
        ]);
        if ($model->load($request->post())) {
            if ($request->isAjax && $model->load($request->post()) && $model->save()) {
                $response = Yii::$app->response;
                $response->format = \yii\web\Response::FORMAT_JSON;
                if ($model->save()) {
                    return [
                        'success' => true,
                        'message' => 'บันทึกการตั้งค่าเรียบร้อย!'
                    ];
                } else {
                    return [
                        'success' => false,
                        'validate' => ActiveForm::validate($model)
                    ];
                }
            } else {
                $this->createPdf($request->post('TbQrcodeSettings'));
            }
        }
        return $this->render('_form', [
                    'model' => $model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreatePaperFormat($url) {
        $request = Yii::$app->request;
        $model = new TbPaperFormat();
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกขนาดกระดาษ',
                    'content' => $this->renderAjax('_form_paper_format', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'url' => $url
                ];
            } else {
                return [
                    'title' => 'บันทึกขนาดกระดาษ',
                    'content' => $this->renderAjax('_form_paper_format', [
                        'model' => $model,
                    ]),
                    'footer' => '',
                    'validate' => ActiveForm::validate($model)
                ];
            }
        }
    }

    public function actionUpdatePaperFormat($id, $url) {
        $request = Yii::$app->request;
        $model = TbPaperFormat::findOne($id);
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกขนาดกระดาษ',
                    'content' => $this->renderAjax('_form_paper_format', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                    'url' => $url
                ];
            } else {
                return [
                    'title' => 'บันทึกขนาดกระดาษ',
                    'content' => $this->renderAjax('_form_paper_format', [
                        'model' => $model,
                    ]),
                    'footer' => ''
                ];
            }
        }
    }

    public function actionView($id) {
        $settings = $this->findModel($id);
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/qrcode-preview.pdf')) {
            FileHelper::unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/qrcode-preview.pdf');
        }
        $qrSize = empty($settings['qrcode_size']) ? '1.6' : $settings['qrcode_size'];
        $qrStyle = '';
        if (!empty($settings['qr_margin_left'])) {
            $qrStyle .= 'margin-left:' . $settings['qr_margin_left'] . 'px;';
        }
        if (!empty($settings['qr_margin_right'])) {
            $qrStyle .= 'margin-right:' . $settings['qr_margin_right'] . 'px;';
        }
        if (!empty($settings['qr_margin_top'])) {
            $qrStyle .= 'margin-top:' . $settings['qr_margin_top'] . 'px;';
        }
        if (!empty($settings['qr_margin_bottom'])) {
            $qrStyle .= 'margin-bottom:' . $settings['qr_margin_bottom'] . 'px;';
        }
        if ($settings['disableborder'] == 2) {
            $template = '<barcode code="https://jolie-g.online" type="QR" size="{size}" error="M" disableborder="1" style="{style}"/>';
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{style}', $qrStyle, $template);
        } else {
            $template = '<barcode code="https://jolie-g.online" type="QR" size="{size}" error="M" style="{style}"/>';
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{style}', $qrStyle, $template);
        }
        $content = '';
        for ($i = 1; $i <= 100; $i++) {
            $content .= $template;
        }
        $size = TbPaperFormat::findOne($settings['format_id']);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            //'format' => Pdf::FORMAT_A4,
            'format' => $size ? [$size['wide'], $size['height']] : Pdf::FORMAT_A4,
            'marginLeft' => empty($settings['marginLeft']) ? false : $settings['marginLeft'],
            'marginRight' => empty($settings['marginRight']) ? false : $settings['marginRight'],
            'marginTop' => empty($settings['marginTop']) ? false : $settings['marginTop'],
            'marginBottom' => empty($settings['marginBottom']) ? false : $settings['marginBottom'],
            'marginHeader' => empty($settings['marginHeader']) ? false : $settings['marginHeader'],
            'marginFooter' => empty($settings['marginFooter']) ? false : $settings['marginFooter'],
            // portrait orientation
            'orientation' => empty($settings['marginFooter']) ? Pdf::ORIENT_PORTRAIT : $settings['orientation'],
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'filename' => 'uploads/qrcode-preview.pdf',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            //'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            //'cssInline' => 'body{font-size:11px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Sticker'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();
        \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('frontend', 'Deleted!'));

        return $this->redirect(['index']);
    }

    public function actionDeletePaperFormat($id, $url) {
        TbPaperFormat::findOne($id)->delete();
        \Yii::$app->session->setFlash(SweetAlert2::TYPE_SUCCESS, \Yii::t('frontend', 'Deleted!'));

        return $this->redirect([$url]);
    }

    private function createPdf($settings) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/qrcode-preview.pdf')) {
            FileHelper::unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/qrcode-preview.pdf');
        }
        $qrSize = empty($settings['qrcode_size']) ? '1.6' : $settings['qrcode_size'];
        $qrStyle = '';
        if (!empty($settings['qr_margin_left'])) {
            $qrStyle .= 'margin-left:' . $settings['qr_margin_left'] . 'px;';
        }
        if (!empty($settings['qr_margin_right'])) {
            $qrStyle .= 'margin-right:' . $settings['qr_margin_right'] . 'px;';
        }
        if (!empty($settings['qr_margin_top'])) {
            $qrStyle .= 'margin-top:' . $settings['qr_margin_top'] . 'px;';
        }
        if (!empty($settings['qr_margin_bottom'])) {
            $qrStyle .= 'margin-bottom:' . $settings['qr_margin_bottom'] . 'px;';
        }
        if ($settings['disableborder'] == 1) {
            $template = '<barcode code="http://jolie-g.online" type="QR" size="{size}" error="M" style="{style}"/>';
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{style}', $qrStyle, $template);
        } else {
            $template = '<barcode code="http://jolie-g.online" type="QR" size="{size}" error="M" disableborder="1" style="{style}"/>';
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{style}', $qrStyle, $template);
        }
        $content = '';
        for ($i = 1; $i <= 177; $i++) {
            $content .= $template;
        }
        $size = TbPaperFormat::findOne($settings['format_id']);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            //'format' => Pdf::FORMAT_A4,
            'format' => $size ? [$size['wide'], $size['height']] : Pdf::FORMAT_A4,
            'marginLeft' => empty($settings['marginLeft']) ? false : $settings['marginLeft'],
            'marginRight' => empty($settings['marginRight']) ? false : $settings['marginRight'],
            'marginTop' => empty($settings['marginTop']) ? false : $settings['marginTop'],
            'marginBottom' => empty($settings['marginBottom']) ? false : $settings['marginBottom'],
            'marginHeader' => empty($settings['marginHeader']) ? false : $settings['marginHeader'],
            'marginFooter' => empty($settings['marginFooter']) ? false : $settings['marginFooter'],
            // portrait orientation
            'orientation' => empty($settings['marginFooter']) ? Pdf::ORIENT_PORTRAIT : $settings['orientation'],
            // stream to browser inline
            'destination' => Pdf::DEST_FILE,
            // your html content input
            'content' => $content,
            'filename' => 'uploads/qrcode-preview.pdf',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            //'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            //'cssInline' => 'body{font-size:11px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Sticker'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    protected function findModel($id) {
        if (($model = TbQrcodeSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPrintQrCode($id, $setting_id = null) {
        $request = Yii::$app->request;
        $modelPrint = $setting_id == null ? new TbQrcodeSettings() : $this->findModelQrcodeSettings($setting_id);
        $modelProduct = $this->findModelProduct($id);
        $selection = [];
        if ($modelPrint->load($request->post())) {
            $post = $request->post();
            $product = $post['TbProduct'];
            if (!empty($product['selection'])) {
                $product['product_id'] = $id;
                $selection = explode('&', $product['selection']);
            }
            $this->createPrintPreview($post['TbQrcodeSettings'], $post['TbProduct']);
        }
        return $this->render('_form_print', [
                    'modelPrint' => $modelPrint,
                    'modelProduct' => $modelProduct,
                    'selection' => $selection
        ]);
    }

    private function createPrintPreview($settings, $modelProduct) {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $modelProduct['product_id'] . '.pdf')) {
            FileHelper::unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $modelProduct['product_id'] . '.pdf');
        }
        $qrSize = empty($settings['qrcode_size']) ? '1.6' : $settings['qrcode_size'];
        $qrStyle = '';
        if (!empty($settings['qr_margin_left'])) {
            $qrStyle .= 'margin-left:' . $settings['qr_margin_left'] . 'px;';
        }
        if (!empty($settings['qr_margin_right'])) {
            $qrStyle .= 'margin-right:' . $settings['qr_margin_right'] . 'px;';
        }
        if (!empty($settings['qr_margin_top'])) {
            $qrStyle .= 'margin-top:' . $settings['qr_margin_top'] . 'px;';
        }
        if (!empty($settings['qr_margin_bottom'])) {
            $qrStyle .= 'margin-bottom:' . $settings['qr_margin_bottom'] . 'px;';
        }
        if ($settings['disableborder'] == 1) {
            $template = '<barcode code="{url}" type="QR" size="{size}" error="M" style="{style}"/>';
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{style}', $qrStyle, $template);
        } else {
            $template = '<barcode code="{url}" type="QR" size="{size}" error="M" disableborder="1" style="{style}"/>';
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{size}', $qrSize, $template);
            $template = str_replace('{style}', $qrStyle, $template);
        }
        $content = [];
        $qrItems = [];
        if (!empty($modelProduct['selection'])) {
            $qrItems = explode('&', $modelProduct['selection']);
        }
        //$qrItems = TbQrItem::find()->where(['qrcode_id' => $keys])->all();
        foreach ($qrItems as $qrcode) {
            $url = Url::base(true) . Url::to(['/app/scan/qrcode', 'code' => $qrcode]);
            $html = str_replace('{url}', $url, $template);
            $content[] = $html;
        }
        $size = $this->findModelPaperFormat($settings['format_id']);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            //'format' => Pdf::FORMAT_A4,
            'format' => $size ? [$size['wide'], $size['height']] : Pdf::FORMAT_A4,
            'marginLeft' => empty($settings['marginLeft']) ? false : $settings['marginLeft'],
            'marginRight' => empty($settings['marginRight']) ? false : $settings['marginRight'],
            'marginTop' => empty($settings['marginTop']) ? false : $settings['marginTop'],
            'marginBottom' => empty($settings['marginBottom']) ? false : $settings['marginBottom'],
            'marginHeader' => empty($settings['marginHeader']) ? false : $settings['marginHeader'],
            'marginFooter' => empty($settings['marginFooter']) ? false : $settings['marginFooter'],
            // portrait orientation
            'orientation' => empty($settings['marginFooter']) ? Pdf::ORIENT_PORTRAIT : $settings['orientation'],
            // stream to browser inline
            'destination' => Pdf::DEST_FILE,
            // your html content input
            'content' => implode('', $content),
            'filename' => 'uploads/' . $modelProduct['product_id'] . '.pdf',
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            //'cssFile' => '@frontend/web/css/kv-mpdf-bootstrap.css',
            // any css to be embedded if required
            //'cssInline' => 'body{font-size:11px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Sticker'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionUpdateStatusPrint() {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $keys = $request->post('keys');

            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                foreach ($keys as $qrcode) {
                    $model = $this->findModelQrItem($qrcode);
                    $model->scenario = 'update';
                    $model->print_status = 1;
                    if (!$model->save()) {
                        throw new \Exception($model->errors);
                    }
                }
                $transaction->commit();
                return [
                    'success' => true,
                    'message' => 'บันทึกสำเร็จ!',
                ];
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
    }

}
