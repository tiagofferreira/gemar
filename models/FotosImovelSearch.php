<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FotosImovel;

/**
 * FotosImovelSearch represents the model behind the search form about `app\models\FotosImovel`.
 */
class FotosImovelSearch extends FotosImovel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'imovel'], 'integer'],
            [['nome_arquivo', 'nome_hash'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = FotosImovel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'imovel' => $this->imovel,
        ]);

        $query->andFilterWhere(['like', 'nome_arquivo', $this->nome_arquivo])
            ->andFilterWhere(['like', 'nome_hash', $this->nome_hash]);

        return $dataProvider;
    }
}
