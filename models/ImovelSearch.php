<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Imovel;

/**
 * ImovelSearch represents the model behind the search form about `app\models\Imovel`.
 */
class ImovelSearch extends Imovel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tipo', 'bairro', 'situacao', 'banheiros', 'suites', 'quartos', 'salas', 'vagas', 'varandas'], 'integer'],
            [['codigo', 'descricao'], 'safe'],
            [['valor', 'condominio', 'iptu', 'area_util', 'area_lote', 'area_const'], 'number'],
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
        $query = Imovel::find();

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
            'tipo' => $this->tipo,
            'bairro' => $this->bairro,
            'situacao' => $this->situacao,
            'valor' => $this->valor,
            'condominio' => $this->condominio,
            'iptu' => $this->iptu,
            'area_util' => $this->area_util,
            'area_lote' => $this->area_lote,
            'area_const' => $this->area_const,
            'banheiros' => $this->banheiros,
            'suites' => $this->suites,
            'quartos' => $this->quartos,
            'salas' => $this->salas,
            'vagas' => $this->vagas,
            'varandas' => $this->varandas,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descricao', $this->descricao]);

        return $dataProvider;
    }
}
