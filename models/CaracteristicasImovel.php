<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "caracteristicas_imovel".
 *
 * @property integer $id
 * @property integer $imovel
 * @property integer $caracteristica
 *
 * @property Caracteristicas $caracteristica0
 * @property Imovel $imovel0
 */
class CaracteristicasImovel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'caracteristicas_imovel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imovel'], 'required'],
            [['imovel', 'caracteristica'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imovel' => 'Imovel',
            'caracteristica' => 'Caracteristica',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCaracteristica0()
    {
        return $this->hasOne(Caracteristicas::className(), ['id' => 'caracteristica']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImovel0()
    {
        return $this->hasOne(Imovel::className(), ['id' => 'imovel']);
    }
}
