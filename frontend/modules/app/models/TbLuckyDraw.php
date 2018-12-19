<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_lucky_draw".
 *
 * @property int $lucky_draw_id
 * @property string $lucky_draw_name ชื่องวดที่จับฉลาก
 * @property int $rewards_id รหัสชุดรางวัล
 * @property string $created_at วันที่บันทึก
 * @property string $updated_at วันที่แก้ไข
 * @property int $created_by ผู้บันทึก
 * @property int $updated_by ผู้แก้ไข
 */
class TbLuckyDraw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_lucky_draw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lucky_draw_name'], 'required'],
            [['rewards_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['lucky_draw_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lucky_draw_id' => Yii::t('frontend', 'Lucky Draw ID'),
            'lucky_draw_name' => Yii::t('frontend', 'ชื่องวดที่จับฉลาก'),
            'rewards_id' => Yii::t('frontend', 'รหัสชุดรางวัล'),
            'created_at' => Yii::t('frontend', 'วันที่บันทึก'),
            'updated_at' => Yii::t('frontend', 'วันที่แก้ไข'),
            'created_by' => Yii::t('frontend', 'ผู้บันทึก'),
            'updated_by' => Yii::t('frontend', 'ผู้แก้ไข'),
        ];
    }
}
