<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fotos_imovel".
 *
 * @property integer $id
 * @property integer $imovel
 * @property string $nome_arquivo
 * @property string $nome_hash
 *
 * @property Imovel $imovel0
 */
class FotosImovel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fotos_imovel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['imovel', 'nome_arquivo', 'nome_hash'], 'required'],
            [['imovel'], 'integer'],
            [['nome_arquivo'], 'string', 'max' => 200],
            [['nome_hash'], 'string', 'max' => 36]
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
            'nome_arquivo' => 'Nome Arquivo',
            'nome_hash' => 'Nome Hash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImovel0()
    {
        return $this->hasOne(Imovel::className(), ['id' => 'imovel']);
    }
}
