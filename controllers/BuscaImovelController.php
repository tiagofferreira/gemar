<?php

namespace app\controllers;

use app\models\Imovel;
use app\models\TipoImovel;
use Yii;

class BuscaImovelController extends \yii\web\Controller
{
    public function actionBusca()
    {
        $tipoImovel = TipoImovel::findAll();
        
        return $this->render('_formBusca',
                            ['tipoImovel'=>$tipoImovel]
                            );
    } 

}
