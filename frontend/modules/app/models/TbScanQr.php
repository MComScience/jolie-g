<?php

namespace frontend\modules\app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use homer\user\models\Profile;

/**
 * This is the model class for table "tb_scan_qr".
 *
 * @property string $qrcode_id หมายเลขคิวอาร์โค้ด
 * @property int $user_id ไอดีลูกค้า
 * @property string $created_at วันที่บันทึก
 * @property string $updated_at วันที่แก้ไข
 */
class TbScanQr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_scan_qr';
    }

    public function behaviors()
    {
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
            // [
            //     'class' => BlameableBehavior::className(),
            //     'attributes' => [
            //         ActiveRecord::EVENT_BEFORE_INSERT => ['user_id', 'user_id'],
            //         ActiveRecord::EVENT_BEFORE_UPDATE => ['user_id'],
            //     ],
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qrcode_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['qrcode_id'], 'string', 'max' => 13],
            [['qrcode_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'qrcode_id' => Yii::t('frontend', 'หมายเลขคิวอาร์โค้ด'),
            'user_id' => Yii::t('frontend', 'ไอดีลูกค้า'),
            'created_at' => Yii::t('frontend', 'วันที่บันทึก'),
            'updated_at' => Yii::t('frontend', 'วันที่แก้ไข'),
        ];
    }

    public function getProfile() {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }

    public function getQrItem() {
        return $this->hasOne(TbQrItem::className(), ['qrcode_id' => 'qrcode_id']);
    }
}
