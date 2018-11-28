<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 25/11/2561
 * Time: 21:28
 */
namespace common\traits;

use frontend\modules\app\models\TbQrcodeSettings;
use yii\web\NotFoundHttpException;
use frontend\modules\app\models\TbProduct;
use frontend\modules\app\models\TbQrItem;
use frontend\modules\app\models\TbPaperFormat;
use frontend\modules\app\models\TbScanQr;

trait ModelTrait
{
    protected function findModelQrcodeSettings($id)
    {
        if (($model = TbQrcodeSettings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelProduct($id)
    {
        if (($model = TbProduct::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelQrItem($id)
    {
        if (($model = TbQrItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPaperFormat($id)
    {
        if (($model = TbPaperFormat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelScanQr($id)
    {
        if (($model = TbScanQr::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}