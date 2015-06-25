<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\TipoImovel;
use app\models\Cidade;
use yii\helpers\ArrayHelper;

class BuscaWidget extends Widget
{

    public function run()
    {
        $tipoImovel = ArrayHelper::map(TipoImovel::find()->all(), 'id', 'nome');
        $cidades = ArrayHelper::map(Cidade::find()->all(), 'codigo', 'nome');
        
        return $this->render('/busca-imovel/_formBusca',
                            ['tipoImovel'=>$tipoImovel,
                             'cidades'=>$cidades
                            ]);
    }

}
    
?>