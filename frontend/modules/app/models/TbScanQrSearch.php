<?php

namespace frontend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\app\models\TbScanQr;

/**
 * TbScanQrSearch represents the model behind the search form of `frontend\modules\app\models\TbScanQr`.
 */
class TbScanQrSearch extends TbScanQr
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qrcode_id', 'created_at', 'updated_at', 'user_id'], 'safe'],
            //[['user_id'], 'integer'],
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
        $query = TbScanQr::find();

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

        $query->joinWith(['profile']);

        // grid filtering conditions
        /* $query->andFilterWhere([
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]); */

        $query->andFilterWhere(['like', 'qrcode_id', $this->qrcode_id])
        ->andFilterWhere(['like', 'created_at', $this->created_at])
        ->andFilterWhere(['like', '`profile`.first_name', $this->user_id])
        ->orFilterWhere(['like', '`profile`.last_name', $this->user_id]);

        return $dataProvider;
    }
}
