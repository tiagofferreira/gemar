<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_imovel".
 *
 * @property integer $id
 * @property string $nome
 *
 * @property Imovel[] $imovels
 */
class TipoImovel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_imovel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
    public function getImovels()
    {
        return $this->hasMany(Imovel::className(), ['tipo' => 'id']);
    }
}
