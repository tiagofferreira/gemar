<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imovel".
 *
 * @property integer $id
 * @property string $codigo
 * @property integer $tipo
 * @property integer $bairro
 * @property integer $situacao
 * @property double $valor
 * @property double $condominio
 * @property double $iptu
 * @property double $area_util
 * @property double $area_lote
 * @property double $area_const
 * @property integer $banheiros
 * @property integer $suites
 * @property integer $quartos
 * @property integer $salas
 * @property integer $vagas
 * @property integer $varandas
 * @property string $descricao
 * @property integer $destaque
 *
 * @property CaracteristicasImovel[] $caracteristicasImovels
 * @property FotosImovel[] $fotosImovels
 * @property Bairro $bairro0
 * @property TipoImovel $tipo0
 */
class Imovel extends \yii\db\ActiveRecord
{
    
    const TIPO_ALUGAR = 0;
    const TIPO_COMPRAR = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imovel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'tipo', 'bairro', 'situacao', 'valor', 'area_util', 'banheiros'], 'required'],
            [['tipo', 'bairro', 'situacao', 'banheiros', 'suites', 'quartos', 'salas', 'vagas', 'varandas', 'destaque'], 'integer'],
            [['valor', 'condominio', 'iptu', 'area_util', 'area_lote', 'area_const'], 'number'],
            [['descricao'], 'string'],
            [['codigo'], 'string', 'max' => 50]
        ];
    }
   
    //Altera o formato exibição de alguns campos
    public function afterFind()
    {                
        //Valores
        $this->valor = 'R$ '.number_format($this->valor, 2, ',', '.');
        $this->condominio = 'R$ '.number_format($this->condominio, 2, ',', '.');
        $this->iptu = 'R$ '.number_format($this->iptu, 2, ',', '.');

        //Medidas
        $this->area_util = is_null($this->area_util) ?  null : $this->area_util.' m²'; 
        $this->area_lote = is_null($this->area_lote) ?  null : $this->area_lote.' m²';         
        $this->area_const = is_null($this->area_const) ?  null : $this->area_const.' m²'; 
        
        parent::afterFind();
        
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'tipo' => 'Tipo',
            'bairro' => 'Bairro',
            'situacao' => 'Situação',
            'valor' => 'Valor',
            'condominio' => 'Condomínio',
            'iptu' => 'IPTU',
            'area_util' => 'Área Útil (m²)',
            'area_lote' => 'Área do Lote (m²)',
            'area_const' => 'Área Construída (m²)',
            'banheiros' => 'Banheiros',
            'suites' => 'Suites',
            'quartos' => 'Quartos',
            'salas' => 'Salas',
            'vagas' => 'Vagas',
            'varandas' => 'Varandas',
            'descricao' => 'Descrição',
            'destaque' => 'Imóvel Destaque'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicasImovel()
    {
        return $this->hasMany(CaracteristicasImovel::className(), ['imovel' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFotosImovel()
    {
        return $this->hasMany(FotosImovel::className(), ['imovel' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBairro0()
    {
        return $this->hasOne(Bairro::className(), ['codigo' => 'bairro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoImovel()
    {
        return $this->hasOne(TipoImovel::className(), ['id' => 'tipo']);
    }
    
    public function getSituacaoNome()
    {
        return $this->situacao == self::TIPO_ALUGAR ? 'Para alugar' : 'Para vender';
    }
}
