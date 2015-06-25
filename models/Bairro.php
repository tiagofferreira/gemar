<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bairro".
 *
 * @property integer $codigo
 * @property integer $cidade
 * @property string $nome
 *
 * @property Cidade $cidade0
 * @property Imovel[] $imovels
 */
class Bairro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bairro';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'cidade', 'nome'], 'required'],
            [['codigo', 'cidade'], 'integer'],
            [['nome'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'cidade' => 'Cidade',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCidade0()
    {
        return $this->hasOne(Cidade::className(), ['codigo' => 'cidade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImovels()
    {
        return $this->hasMany(Imovel::className(), ['bairro' => 'codigo']);
    }
}
