<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_paper_format".
 *
 * @property int $format_id
 * @property string $format_name ชื่อขนาดกระดาษ
 * @property int $wide Wide (mm)
 * @property int $height Height (mm)
 */
class TbPaperFormat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_paper_format';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['format_name', 'wide', 'height'], 'required'],
            [['wide', 'height'], 'integer'],
            [['format_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'format_id' => Yii::t('frontend', 'Format ID'),
            'format_name' => Yii::t('frontend', 'ชื่อขนาดกระดาษ'),
            'wide' => Yii::t('frontend', 'Wide (mm)'),
            'height' => Yii::t('frontend', 'Height (mm)'),
        ];
    }
}
