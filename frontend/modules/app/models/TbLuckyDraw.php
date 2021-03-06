<?php

namespace frontend\modules\app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use homer\behaviors\CoreMultiValueBehavior;
use common\components\DateConvert;
use homer\user\models\Profile;
use frontend\modules\app\models\TbRewards;
use frontend\modules\app\models\TbItem;

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
class TbLuckyDraw extends \yii\db\ActiveRecord implements \dixonstarter\togglecolumn\ToggleActionInterface {

    use \dixonstarter\togglecolumn\ToggleActionTrait;
    
    public $seleted_all;

    public function getToggleItems() {
        // custom array for toggle update
        return [
            'on' => ['value' => 1, 'label' => 'ประกาศ'],
            'off' => ['value' => 0, 'label' => 'ปิดประกาศ'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tb_lucky_draw';
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => CoreMultiValueBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'begin_date', 'end_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['created_at', 'begin_date', 'end_date'],
                ],
                'value' => function ($event) {
                    return DateConvert::convertToDatabase($event->sender[$event->data], false);
                },
            ],
            [
                'class' => CoreMultiValueBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['created_at', 'begin_date', 'end_date'],
                ],
                'value' => function ($event) {
                    return DateConvert::convertToDisplay($event->sender[$event->data], false);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['lucky_draw_name', 'item_id', 'product_id'], 'required'],
            [['rewards_id', 'created_by', 'updated_by', 'item_id', 'lucky_draw_condition', 'publish'], 'integer'],
            [['created_at', 'updated_at', 'begin_date', 'end_date'], 'safe'],
            [['lucky_draw_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'lucky_draw_id' => Yii::t('frontend', 'Lucky Draw ID'),
            'lucky_draw_name' => Yii::t('frontend', 'ชื่องวดที่จับฉลาก'),
            'rewards_id' => Yii::t('frontend', 'รหัสชุดรางวัล'),
            'created_at' => Yii::t('frontend', 'วันที่บันทึก'),
            'updated_at' => Yii::t('frontend', 'วันที่แก้ไข'),
            'created_by' => Yii::t('frontend', 'ผู้บันทึก'),
            'updated_by' => Yii::t('frontend', 'ผู้แก้ไข'),
            'item_id' => Yii::t('frontend', 'ชื่อสินค้า'),
            'product_id' => Yii::t('frontend', 'กลุ่มคิวอาร์โค้ด'),
            'lucky_draw_condition' => Yii::t('frontend', 'เงื่อนไขการจับฉลาก'),
            'begin_date' => Yii::t('frontend', 'วันเริ่ม'),
            'end_date' => Yii::t('frontend', 'วันสิ้นสุด'),
            'publish' => Yii::t('frontend', 'ประกาศ'),
        ];
    }

    public function getUserCreate() {
        return $this->hasOne(Profile::className(), ['user_id' => 'created_by']);
    }

    public function getTbRewards() {
        return $this->hasOne(TbRewards::className(), ['rewards_id' => 'rewards_id']);
    }

    public function getTbItem() {
        return $this->hasOne(TbItem::className(), ['item_id' => 'item_id']);
    }

    public function getRewrads($item_rewards_id) {
        $rows = (new \yii\db\Query())
                ->select([
                    'tb_lucky_darw_reward.lucky_draw_reward_id',
                    'tb_lucky_darw_reward.qrcode_id',
                    'tb_lucky_darw_reward.lucky_draw_id',
                    'tb_lucky_darw_reward.item_rewards_id',
                    '`profile`.first_name',
                    '`profile`.last_name',
                    'tb_province.province_name',
                    '`profile`.tel'
                ])
                ->from('tb_lucky_darw_reward')
                ->where([
                    'tb_lucky_darw_reward.lucky_draw_id' => $this->lucky_draw_id,
                    'tb_lucky_darw_reward.item_rewards_id' => $item_rewards_id
                ])
                ->innerJoin('tb_scan_qr', 'tb_scan_qr.qrcode_id = tb_lucky_darw_reward.qrcode_id')
                ->innerJoin('`profile`', '`profile`.user_id = tb_scan_qr.user_id')
                ->leftJoin('tb_province', 'tb_province.province_id = `profile`.province')
                ->innerJoin('tb_item_rewards', 'tb_item_rewards.item_rewards_id = tb_lucky_darw_reward.item_rewards_id')
                ->orderBy('tb_item_rewards.rewards_no ASC')
                ->all();
        return $rows;
    }

}
