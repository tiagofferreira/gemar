<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caracteristicas".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property CaracteristicasImovel[] $caracteristicasImovels
 */
class Caracteristicas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'caracteristicas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome'],'required'],
            [['nome'],'unique'],
            [['nome'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristicasImovels()
    {
        return $this->hasMany(CaracteristicasImovel::className(), ['caracteristica' => 'id']);
    }
        
}
