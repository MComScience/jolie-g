<?php

namespace frontend\modules\app\models;

use homer\user\models\Profile;
use mdm\autonumber\Behavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tb_product".
 *
 * @property string $product_id เลขที่สินค้า
 * @property string $product_name ชื่อสินค้า
 * @property string $created_at วันที่บันทึก
 * @property string $updated_at วันที่แก้ไข
 * @property int $created_by ผู้บันทึก
 * @property int $updated_by ผู้แก้ไข
 */
class TbProduct extends \yii\db\ActiveRecord
{
    public $qrcode_qty;

    public $qrcode;

    public $selection;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_product';
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
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
            ],
            [
                'class' => Behavior::className(),
                'attribute' => 'product_id', // required
                'group' => $this->product_id, // optional
                'value' => date('ymd') . '?', // format auto number. '?' will be replaced with generated number
                'digit' => 5 // optional, default to null.
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['product_id'], 'autonumber', 'format' => date('ymd') . '?'],
            [['product_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['product_id'], 'string', 'max' => 100],
            [['product_name','note'], 'string', 'max' => 255],
            [['product_id'], 'unique'],
            ['qrcode_qty', 'validateQty'],
        ];
    }

    public function validateQty($attribute, $params, $validator)
    {
        if ($this->$attribute > 1000) {
            $this->addError($attribute, 'จำนวนการสร้างคิวอาร์โค้ดต่อครั้ง จำกัดที่ 1000');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('frontend', 'เลขที่สินค้า'),
            'product_name' => Yii::t('frontend', 'ชื่อสินค้า'),
            'created_at' => Yii::t('frontend', 'วันที่บันทึก'),
            'updated_at' => Yii::t('frontend', 'วันที่แก้ไข'),
            'created_by' => Yii::t('frontend', 'ผู้บันทึก'),
            'updated_by' => Yii::t('frontend', 'ผู้แก้ไข'),
            'qrcode_qty' => Yii::t('frontend', 'รหัสคิวอาร์โค้ด'),
            'note' => Yii::t('frontend', 'หมายเหตุ'),
        ];
    }

    public function getQrItems()
    {
        return $this->hasMany(TbQrItem::className(), ['product_id' => 'product_id']);
    }

    public function getUserCreate()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }
}
