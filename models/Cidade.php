<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cidade".
 *
 * @property integer $codigo
 * @property integer $uf
 * @property string $nome
 *
 * @property Bairro[] $bairros
 * @property Uf $uf0
 */
class Cidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'uf', 'nome'], 'required'],
            [['codigo', 'uf'], 'integer'],
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
            'uf' => 'Uf',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBairros()
    {
        return $this->hasMany(Bairro::className(), ['cidade' => 'codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUf0()
    {
        return $this->hasOne(Uf::className(), ['codigo' => 'uf']);
    }
}
