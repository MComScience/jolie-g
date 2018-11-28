<?php

namespace frontend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\app\models\TbQrcodeSettings;

/**
 * TbQrcodeSettingsSearch represents the model behind the search form of `frontend\modules\app\models\TbQrcodeSettings`.
 */
class TbQrcodeSettingsSearch extends TbQrcodeSettings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['setting_id', 'format_id', 'marginLeft', 'marginRight', 'marginTop', 'marginBottom', 'marginHeader', 'marginFooter', 'disableborder', 'qr_margin_left', 'qr_margin_right', 'qr_margin_top', 'qr_margin_bottom'], 'integer'],
            [['setting_name', 'orientation', 'filename'], 'safe'],
            [['qrcode_size'], 'number'],
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
        $query = TbQrcodeSettings::find();

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
            'setting_id' => $this->setting_id,
            'format_id' => $this->format_id,
            'marginLeft' => $this->marginLeft,
            'marginRight' => $this->marginRight,
            'marginTop' => $this->marginTop,
            'marginBottom' => $this->marginBottom,
            'marginHeader' => $this->marginHeader,
            'marginFooter' => $this->marginFooter,
            'qrcode_size' => $this->qrcode_size,
            'disableborder' => $this->disableborder,
            'qr_margin_left' => $this->qr_margin_left,
            'qr_margin_right' => $this->qr_margin_right,
            'qr_margin_top' => $this->qr_margin_top,
            'qr_margin_bottom' => $this->qr_margin_bottom,
        ]);

        $query->andFilterWhere(['like', 'setting_name', $this->setting_name])
            ->andFilterWhere(['like', 'orientation', $this->orientation])
            ->andFilterWhere(['like', 'filename', $this->filename]);

        return $dataProvider;
    }
}
