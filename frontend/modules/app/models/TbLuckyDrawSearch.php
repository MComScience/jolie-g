<?php

namespace frontend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\app\models\TbLuckyDraw;

/**
 * TbLuckyDrawSearch represents the model behind the search form of `frontend\modules\app\models\TbLuckyDraw`.
 */
class TbLuckyDrawSearch extends TbLuckyDraw
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lucky_draw_id', 'rewards_id', 'created_by', 'updated_by','item_id','product_id'], 'integer'],
            [['lucky_draw_name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TbLuckyDraw::find()->orderBy('lucky_draw_id desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'lucky_draw_id' => $this->lucky_draw_id,
            'rewards_id' => $this->rewards_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'item_id' => $this->item_id,
            'product_id' => $this->product_id,
        ]);

        $query->andFilterWhere(['like', 'lucky_draw_name', $this->lucky_draw_name]);

        return $dataProvider;
    }
}
