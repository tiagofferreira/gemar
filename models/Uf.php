<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "uf".
 *
 * @property integer $codigo
 * @property string $sigla
 * @property string $nome
 *
 * @property Cidade[] $cidades
 */
class Uf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'sigla', 'nome'], 'required'],
            [['codigo'], 'integer'],
            [['sigla'], 'string', 'max' => 2],
            [['nome'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'codigo' => 'Codigo',
            'sigla' => 'Sigla',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCidades()
    {
        return $this->hasMany(Cidade::className(), ['uf' => 'codigo']);
    }
}
