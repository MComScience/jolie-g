<?php

namespace frontend\modules\app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tb_qr_item".
 *
 * @property int $qrcode_id เลขที่ QR Code
 * @property string $product_id เลขที่สินค้า
 * @property string $created_at วันที่บันทึก
 * @property string $updated_at วันที่แก้ไข
 * @property int $created_by ผู้บันทึก
 * @property int $updated_by ผู้แก้ไข
 */
class TbQrItem extends \yii\db\ActiveRecord {

    const SCENARIO_PRINT = 'print';
    const SCENARIO_CREATE = 'create';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tb_qr_item';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['qrcode_id', 'product_id'], 'unique', 'targetAttribute' => ['qrcode_id', 'product_id'],'on' =>'create'],
            [['qrcode_id', 'product_id'], 'required'],
            [['created_by', 'updated_by', 'print_status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['qrcode_id'], 'string', 'max' => 13],
            [['product_id'], 'string', 'max' => 100],
            [['qrcode_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     * 
     */
    public function attributeLabels() {
        return [
            'qrcode_id' => Yii::t('frontend', 'เลขที่ QR Code'),
            'product_id' => Yii::t('frontend', 'เลขที่สินค้า'),
            'created_at' => Yii::t('frontend', 'วันที่บันทึก'),
            'updated_at' => Yii::t('frontend', 'วันที่แก้ไข'),
            'created_by' => Yii::t('frontend', 'ผู้บันทึก'),
            'updated_by' => Yii::t('frontend', 'ผู้แก้ไข'),
            'print_status' => Yii::t('frontend', 'สถานะการพิมพ์'),
        ];
    }

    public function getProduct() {
        return $this->hasOne(TbProduct::className(), ['product_id' => 'product_id']);
    }

    public function scenarios() {
        return [
            'create' => ['qrcode_id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'print_status'],
            'update' => ['qrcode_id', 'product_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'print_status'],
        ];
    }

}
