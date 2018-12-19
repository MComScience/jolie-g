<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_lucky_darw_reward".
 *
 * @property int $lucky_draw_reward_id
 * @property string $qrcode_id เลขที่ QR Code
 * @property int $lucky_draw_id รหัสครั้งที่จับฉลาก
 * @property int $item_rewards_id รหัสรางวัล
 */
class TbLuckyDarwReward extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_lucky_darw_reward';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qrcode_id', 'lucky_draw_id', 'item_rewards_id'], 'required'],
            [['lucky_draw_id', 'item_rewards_id'], 'integer'],
            [['qrcode_id'], 'string', 'max' => 13],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lucky_draw_reward_id' => Yii::t('frontend', 'Lucky Draw Reward ID'),
            'qrcode_id' => Yii::t('frontend', 'เลขที่ QR Code'),
            'lucky_draw_id' => Yii::t('frontend', 'รหัสครั้งที่จับฉลาก'),
            'item_rewards_id' => Yii::t('frontend', 'รหัสรางวัล'),
        ];
    }
}
