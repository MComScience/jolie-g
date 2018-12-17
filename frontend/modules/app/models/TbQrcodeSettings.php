<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_qrcode_settings".
 *
 * @property int $setting_id
 * @property string $setting_name ชื่อการตั้งค่า
 * @property int $format_id
 * @property int $marginLeft
 * @property int $marginRight
 * @property int $marginTop
 * @property int $marginBottom
 * @property int $marginHeader
 * @property int $marginFooter
 * @property string $orientation
 * @property string $filename
 * @property double $qrcode_size
 * @property int $disableborder
 * @property int $qr_margin_left
 * @property int $qr_margin_right
 * @property int $qr_margin_top
 * @property int $qr_margin_bottom
 */
class TbQrcodeSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_qrcode_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_name', 'format_id'], 'required'],
            [['format_id', 'marginLeft', 'marginRight', 'marginTop', 'marginBottom', 'marginHeader', 'marginFooter', 'disableborder', 'qr_margin_left', 'qr_margin_right', 'qr_margin_top', 'qr_margin_bottom'], 'safe'],
            [['qrcode_size'], 'number'],
            [['setting_name', 'filename'], 'string', 'max' => 100],
            [['orientation'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => Yii::t('frontend', 'Setting ID'),
            'setting_name' => Yii::t('frontend', 'ชื่อการตั้งค่า'),
            'format_id' => Yii::t('frontend', 'Format ID'),
            'marginLeft' => Yii::t('frontend', 'Margin Left'),
            'marginRight' => Yii::t('frontend', 'Margin Right'),
            'marginTop' => Yii::t('frontend', 'Margin Top'),
            'marginBottom' => Yii::t('frontend', 'Margin Bottom'),
            'marginHeader' => Yii::t('frontend', 'Margin Header'),
            'marginFooter' => Yii::t('frontend', 'Margin Footer'),
            'orientation' => Yii::t('frontend', 'Orientation'),
            'filename' => Yii::t('frontend', 'Filename'),
            'qrcode_size' => Yii::t('frontend', 'Qrcode Size'),
            'disableborder' => Yii::t('frontend', 'Disableborder'),
            'qr_margin_left' => Yii::t('frontend', 'Qr Margin Left'),
            'qr_margin_right' => Yii::t('frontend', 'Qr Margin Right'),
            'qr_margin_top' => Yii::t('frontend', 'Qr Margin Top'),
            'qr_margin_bottom' => Yii::t('frontend', 'Qr Margin Bottom'),
        ];
    }

    public function getTbPaperFormat()
    {
        return $this->hasOne(TbPaperFormat::className(), ['format_id' => 'format_id']);
    }
}
