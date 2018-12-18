<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_item_rewards".
 *
 * @property int $item_rewards_id
 * @property int $rewards_id รหัสรางวัล
 * @property int $rewards_no รางวัลที่
 * @property string $rewards_name รางวัล
 * @property int $rewards_amount จำนวนรางวัล
 * @property string $cost มูลค่า
 * @property string $comment comment
 */
class TbItemRewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_item_rewards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rewards_no', 'rewards_name', 'rewards_amount'], 'required'],
            [['rewards_id', 'rewards_no', 'rewards_amount'], 'integer'],
            [['cost'], 'number'],
            [['rewards_name', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_rewards_id' => Yii::t('frontend', 'Item Rewards ID'),
            'rewards_id' => Yii::t('frontend', 'รหัสรางวัล'),
            'rewards_no' => Yii::t('frontend', 'รางวัลที่'),
            'rewards_name' => Yii::t('frontend', 'รางวัล'),
            'rewards_amount' => Yii::t('frontend', 'จำนวนรางวัล'),
            'cost' => Yii::t('frontend', 'มูลค่า'),
            'comment' => Yii::t('frontend', 'comment'),
        ];
    }
}
